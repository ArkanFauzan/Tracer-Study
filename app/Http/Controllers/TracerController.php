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

    public function datatable(Request $request)
    {
        $query = $request->query();
        $count = Tracer::count();
        
        $tracers = Tracer::orderBy('valid_until', 'DESC')->get();
        $result = [];

        foreach ($tracers as $key => $tracer) {
            $result[] = [
                'no' => $key + 1,
                'title' => $tracer->name,
                'description' => $tracer->description,
                'valid_until' => $tracer->valid_until->format('Y-m-d H:i:s'),
                'form_link' => '
                    <a class="btn btn-info btn-sm" href="'.route('form.tracerStudy', $tracer->id).'" target="_blank" title="Form Tracer Study">Form Tracer Study</a> <br><br>
                    <a class="btn btn-info btn-sm" href="'.route('form.tracerStudy', $tracer->id).'" target="_blank" title="Form User Satisfaction">Form User Satisfaction</a>
                ',
                'action' => '
                    <form action="'.route('tracers.destroy', $tracer->id).'" method="POST">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="'.csrf_token().'" autocomplete="off">

                        <a class="btn btn-info btn-sm" href="'.route('tracers.show', $tracer->id).'" title="Detail"><i class="fas fa-eye"></i></a>
                        <a class="btn btn-primary btn-sm" href="'.route('tracers.edit', $tracer->id).'" title="Edit"><i class="fas fa-edit"></i></a>
                        <button type="submit" class="btn btn-danger btn-sm button-delete" data-text="'.(str_replace('\"', '', $tracer->name)).'" title="Delete"><i class="fas fa-trash-alt"></i></button>
                    </form>
                '
            ];
        }

        return response()->json([
            'draw' => $query['draw'],
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $result
        ]);
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
