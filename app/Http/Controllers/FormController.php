<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormController extends Controller
{
    public function tracerStudy(string $id)
    {
        $form = [];
        return view('dashboard.tracers.index', [...compact('Form'), 'title' => 'Tracers']);
    }

    public function userSatisfaction()
    {
        $form = [];
        return view('dashboard.tracers.index', [...compact('Form'), 'title' => 'Tracers']);
    }
}
