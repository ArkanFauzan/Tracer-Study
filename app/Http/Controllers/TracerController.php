<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tracer;

class TracerController extends Controller
{
    public function index()
    {
        $tracers = Tracer::orderBy('created_at', 'DESC')->get();

        return view('dashboard.tracers.index', [...compact('tracers'), 'title' => 'Tracers']);
    }

    public function create()
    {
        return view('dashboard.tracers.create', ['title' => 'Add Tracer']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'string|nullable',
            'valid_until' => 'date|nullable'
        ]);

        $data = $request->all();

        $time = strtotime($data['valid_until']);
        $data['valid_until'] = date('Y-m-d 23:59:59', $time); // for ending day

        Tracer::create($data);
        return redirect()->route('tracers.index')->with('success', 'Tracer created successfully.');
    }

    public function show(Tracer $tracer)
    {
        return view('dashboard.tracers.show', [...compact('tracer'), 'title' => 'Detail Tracer']);
    }

    public function edit(Tracer $tracer)
    {
        return view('dashboard.tracers.edit', [...compact('tracer'), 'title' => 'Edit Tracer']);
    }

    public function update(Request $request, Tracer $tracer)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'string|nullable',
            'valid_until' => 'date|nullable'
        ]);

        $data = $request->all();

        $time = strtotime($data['valid_until']);
        $data['valid_until'] = date('Y-m-d 23:59:59', $time); // for ending day

        $tracer->update($data);
        return redirect()->route('tracers.index')->with('success', 'Tracer updated successfully.');
    }

    public function destroy(Tracer $tracer)
    {
        $tracer->delete();
        return redirect()->route('tracers.index')->with('success', 'Tracer deleted successfully.');
    }
}
