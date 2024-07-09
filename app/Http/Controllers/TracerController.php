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
        $requestQuery = $request->query();

        $queryDB = Tracer::query();

        // search query
        if (!empty($requestQuery['search']['value'])) {
            $queryDB->where(function($query) use($requestQuery) {
                $query
                    ->where('name', 'like', "%{$requestQuery['search']['value']}%")
                    ->orWhere('description', 'like', "%{$requestQuery['search']['value']}%");
            });
        }

        // order query
        if (!empty($requestQuery['order'])) { // if exist sortable

            // idx = column order in datatable
            // value = the value is column name in database
            // modify orderable column in frontend
            $columns = [
                'no',
                'name',
                'description',
                'valid_until',
                'form_link',
                'action'
            ];
            
            $orderBy = $columns[ $requestQuery['order'][0]['column'] ];
            $order = $requestQuery['order'][0]['dir'];

            if (! in_array($orderBy, ['no', 'form_link', 'action'])) { // not in array (allowed sortable)
                $queryDB->orderBy($orderBy, strtoupper($order));
            }
        }
    
        $countQeury = clone $queryDB;
        $count = $countQeury->count();

        $tracers = $queryDB->skip((int)$requestQuery['start'])->take((int)$requestQuery['length'])->get();
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
            'draw' => $requestQuery['draw'],
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
