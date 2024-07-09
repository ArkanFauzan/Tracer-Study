<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Tracer;
use App\Models\UserSatisfactionIndicator;
use App\Models\UserSatisfactionOption;

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
        
        return view('form.user_satisfaction', ['title' => 'Form Kepuasan Pengguna', ...compact('questions', 'options')]);
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
