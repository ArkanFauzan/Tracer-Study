<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

        return view('form.user_satisfaction', ['successSubmit' => true]);

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
