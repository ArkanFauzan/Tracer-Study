<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Tracer;
use App\Models\UserSatisfactionIndicator;
use App\Models\UserSatisfactionOption;
use App\Models\MajorType;
use App\Models\UserSatisfactionResponse;
use App\Models\UserSatisfactionResponseValue;

class FormController extends Controller
{
    public function tracerStudy(string $id)
    {
        Tracer::find($id);
        $form = [];
        return view('form.tracer_study', ['title' => 'Tracers']);
    }

    public function userSatisfaction(string $id)
    {
        // Query to fetch records
        $tracer = $this->getTracer($id);

        if (!$tracer) {
            return view('form.user_satisfaction', ['invalidForm' => true]);
        }
        
        $questions = UserSatisfactionIndicator::orderBy('created_at', 'ASC')->get();
        $options = UserSatisfactionOption::orderBy('created_at', 'ASC')->get();
        $majorTypes = MajorType::with(['major' => function ($query) {
            $query->orderBy('name', 'asc');
        }])
        ->orderBy('created_at', 'asc')->get();
        
        return view('form.user_satisfaction', ['title' => 'Form Kepuasan Pengguna', ...compact('questions', 'options', 'majorTypes', 'tracer')]);
    }

    public function userSatisfactionStore(Request $request)
    {
        // validate tracer (must valid and not expired)
        $tracer = $this->getTracer($request->tracer_id);
        if (!$tracer) {
            return view('form.user_satisfaction', ['invalidForm' => true]);
        }

        // validate question and option
        $questionValidate = [
            'major_id' => 'required|uuid|exists:majors,id',
        ];

        $questions = UserSatisfactionIndicator::orderBy('created_at', 'ASC')->get();
        foreach ($questions as $question) {
            $questionValidate[$question->id] = 'required|uuid|exists:user_satisfaction_options,id'; // format: ['question_id' => 'option_id']
        }

        $request->validate($questionValidate);

        $requestData = $request->all();

        $userSatisfactionResponse = UserSatisfactionResponse::create([
            'tracer_id' => $tracer->id,
            'major_id' => $requestData['major_id'],
        ]);
        
        foreach (array_keys($questionValidate) as $question_id) {
            if ($question_id === 'major_id') {
                continue;
            }

            UserSatisfactionResponseValue::create([
                'user_satisfaction_response_id' => $userSatisfactionResponse->id,
                'user_satisfaction_indicator_id' => $question_id,
                'user_satisfaction_option_id' => $requestData[$question_id]
            ]);
        }

        return redirect()->route('form.userSatisfaction', $tracer->id)->with('success', 'success submitted!');

    }

    private function getUserSatisfactionVariable(Request $request)
    {
        // filter tracer
        $tracers = Tracer::all();
        $tracer_id = !empty($request->query()['tracer_id']) ? $request->query()['tracer_id'] : '';

        // filter major
        $majorTypes = MajorType::with(['major' => function ($query) {
            $query->orderBy('name', 'asc');
        }])
        ->orderBy('created_at', 'asc')->get();
        $major_id = !empty($request->query()['major_id']) ? $request->query()['major_id'] : '';

        $result = [
            'indicators' => [],
            'options' => [], // raw totalCount each option indicator
            'indicatorsTotalSubmit' => [], // totalSubmit each indicator (from all options)
            'optionsPercentage' => [], // each option indicator : indicatorTotalSubmit * 100
        ];

        $indicators = UserSatisfactionIndicator::orderBy('created_at', 'ASC')->get();
        foreach ($indicators as $indicator) {
            $result['indicators'][$indicator->id] = $indicator->name;
        }

        $options = UserSatisfactionOption::orderBy('created_at', 'ASC')->get();
        foreach ($options as $idx => $option) {
            $result['options'][$idx] = [
                'id' => $option->id,
                'option' => $option->option,
                'data' => [] // format: 'indicator_id' => totalCount
            ];

            // defalut totalCount each indicator (0)
            foreach (array_keys($result['indicators']) as $indicator_id) {
                $result['options'][$idx]['data'][$indicator_id] = 0;
            }

            // replace with actual form value response
            $query = UserSatisfactionResponseValue::select(DB::raw('count(*) as total, user_satisfaction_indicator_id'))->where('user_satisfaction_option_id', $option->id);
            if (!empty($tracer_id) || !empty($major_id)) {
                $query->join('user_satisfaction_responses', 'user_satisfaction_response_values.user_satisfaction_response_id', '=', 'user_satisfaction_responses.id');
                if (!empty($tracer_id)) {
                    $query->where('tracer_id', $tracer_id);
                }
                if (!empty($major_id)) {
                    $query->where('major_id', $major_id);
                }
            }
            $userSatisfactionResponseValues = $query->groupBy('user_satisfaction_indicator_id')->get();
            foreach ($userSatisfactionResponseValues as $val) {
                $result['options'][$idx]['data'][$val->user_satisfaction_indicator_id] = $val->total;
            }
        }

        // totalSubmit each indicator (from all options)
        foreach (array_keys($result['indicators']) as $indicator_id) {
            $sum = 0;
            foreach ($result['options'] as $option) {
                $sum += $option['data'][$indicator_id];
            }
            $result['indicatorsTotalSubmit'][$indicator_id] = $sum;
        }

        // calculate option percentage (each option indicator : indicatorTotalSubmit * 100) & average percent
        $result['optionsPercentage'] = $result['options'];
        foreach ($result['optionsPercentage'] as $i => $option) {
            $totalPercent = 0;
            $totalData = 0;
            foreach ($option['data'] as $indicator_id => $val) {
                $indicatorTotalSubmit = $result['indicatorsTotalSubmit'][$indicator_id];
                $percent = $indicatorTotalSubmit > 0 ? $val/$indicatorTotalSubmit*100 : 0; 

                $result['optionsPercentage'][$i]['data'][$indicator_id] = number_format($percent, 2, ',', '.');

                $totalPercent += $percent;
                $totalData++;
            }
            $result['optionsPercentage'][$i]['average'] = number_format(($totalPercent/$totalData), 2, ',', '.');
        }

        return ['title' => 'User Satisfaction', ...compact('result', 'tracer_id', 'tracers', 'major_id', 'majorTypes')];
    }

    public function userSatisfactionResult(Request $request)
    {
        $result = $this->getUserSatisfactionVariable($request);
        return view('dashboard.userSatisfaction.index', $result);
    }

    public function userSatisfactionResultExport(Request $request)
    {
        $data = $this->getUserSatisfactionVariable($request);

        $totalColumn = 2 + count($data['result']['optionsPercentage']);
        
        $tableTitle = "";
        
        if (!empty($data['tracer_id'])) { // from query string
            foreach ($data['tracers'] as $tracer) {
                if ($tracer->id === $data['tracer_id']) {
                    $tableTitle .= "<tr><td colspan='$totalColumn'>Tracer : ".strtoupper($tracer->name)."</td></tr>";
                }
            }
        }
        else {
            $tableTitle .= "<tr><td colspan='$totalColumn'>Tracer : ALL</td></tr>";
        }

        if (!empty($data['major_id'])) { // from query string
            foreach ($data['majorTypes'] as $majorType) {
                foreach ($majorType->major as $major) {
                    if ($major->id === $data['major_id']) {
                        $tableTitle .= "<tr><td colspan='$totalColumn'>Major : {$majorType->name} - {$major->name}</td></tr>";
                    }
                }
            }
        }
        else {
            $tableTitle .= "<tr><td colspan='$totalColumn'>Major : ALL</td></tr>";
        }

        $tableHead = "
            <thead>
                <tr>
                    <th>No</th>
                    <th>Indikator</th>
                    ".implode('', array_map(function($val){
                        return "<th>{$val['option']}</th>";
                    }, $data['result']['optionsPercentage']))."
                </tr>
            </thead>
        ";

        global $i;
        $i = 0;
        $tableBody = "
            <tbody>
                ".implode('', array_map(function($indicatorName, $indicator_id) use($data){
                    global $i;
                    $i++;

                    $value = "";
                    foreach ($data['result']['optionsPercentage'] as $val){
                        $value .= "<th>{$val['data'][$indicator_id]} %</th>";
                    }
                    return "
                        <tr>
                            <td>".($i)."</td>
                            <td>{$indicatorName}</td>
                            {$value}
                        </tr>
                    ";
                }, $data['result']['indicators'], array_keys($data['result']['indicators'])))."

                <tr>
                    <td colspan='2'>Rata-Rata</td>
                    ".implode('', array_map(function($val){
                        return "<th> {$val['average']} %</th>";
                    }, $data['result']['optionsPercentage']))."
                </tr>
            </tbody>
        ";

        $table = "$tableTitle $tableHead $tableBody";

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();
        $spreadsheet = $reader->loadFromString($table);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="user-satisfaction.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

    /**
     * Get and Validate tracer id
     */
    private function getTracer(string $id)
    {
        // Get the current date
        $currentDate = Carbon::now()->getTimestamp();

        // Query to fetch records
        $tracer = Tracer::where('id', $id)
                        ->first();

        if (!$tracer) {
            return null;
        }
        
        $valid_until = Carbon::createFromFormat('Y-m-d H:i:s', $tracer->valid_until->format('Y-m-d H:i:s'))->getTimestamp();
        if ($valid_until < $currentDate) {
            return null;
        }

        return $tracer;
    }
}
