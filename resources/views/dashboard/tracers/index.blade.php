<x-app-layout>

    <x-slot name="pageHeading">
        <h1 class="h3 mb-0 text-gray-800">{{$title ?? ''}}</h1>
    </x-slot>

    <div class="row">
        <div class="col-lg-12 mb-4">
            <a class="btn btn-success" href="{{ route('tracers.create') }}">Create New Tracer</a>
        </div>
    </div>
    <div class="row" style="background-color:white">
        <div class="col-lg-12 mb-4">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
            <div>
                <input type="hidden" id="ajax_datatable_link" value="{{ route('tracers.datatable') }}">
                <table id="datatable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Valid Until</th>
                            <th>Form Link</th>
                            <th width="180px">Action</th> <!-- Lebar kolom dikurangi karena ikon lebih kecil -->
                        </tr>
                    </thead>
                    @php $i = 0; @endphp
                    @foreach ($tracers as $tracer)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $tracer->name }}</td>
                        <td>{{ $tracer->description }}</td>
                        <td>{{ $tracer->valid_until }}</td>
                        <td>
                            <a class="btn btn-info btn-sm" href="{{ route('form.tracerStudy', $tracer->id) }}" target="_blank" title="Form Tracer Study">Form Tracer Study</a> <br><br>
                            <a class="btn btn-info btn-sm" href="{{ route('form.userSatisfaction', $tracer->id) }}" target="_blank" title="Form User Satisfaction">Form User Satisfaction</a>
                        </td>
                        <td>
                            <form action="{{ route('tracers.destroy', $tracer->id) }}" method="POST">
                                <a class="btn btn-info btn-sm" href="{{ route('tracers.show', $tracer->id) }}" title="Detail"><i class="fas fa-eye"></i></a>
                                <a class="btn btn-primary btn-sm" href="{{ route('tracers.edit', $tracer->id) }}" title="Edit"><i class="fas fa-edit"></i></a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm button-delete" data-text="{{$tracer->name}}" title="Delete"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

    <x-slot name="pageCSS">
        <link href="https://cdn.datatables.net/v/dt/dt-2.0.8/datatables.min.css" rel="stylesheet">
        <style>
            select[name="datatable_length"] {
                width: 60px;
                margin-right: 10px;
            }
            table th {
                text-align: left !important;
            }
        </style>
    </x-slot>

    <x-slot name="pageScript">
        <script src="https://cdn.datatables.net/v/dt/dt-2.0.8/datatables.min.js"></script>
        <script>
            function confirmDelete(e){
                e.preventDefault();
                const {text} = e.target.dataset;
                const confirm = window.confirm(`Are you sure want to delete?`);
                if (confirm) {
                    e.target.parentNode.submit();
                }
            }

            function enableDeleteButton(){
                let deleteBtns = document.querySelectorAll(".button-delete");
    
                if (deleteBtns) {
                    for (let i = 0; i < deleteBtns.length; i++) {
                        deleteBtns[i].addEventListener('click', confirmDelete)
                    }
                }
            }

            new DataTable('#datatable', {
                ajax: document.getElementById('ajax_datatable_link').value,
                columns: [
                    { data: 'no', orderable: false, searchable: false },
                    { data: 'title', orderable: true, searchable: true },
                    { data: 'description', orderable: true, searchable: true },
                    { data: 'valid_until', orderable: true, searchable: false },
                    { data: 'form_link', orderable: false, searchable: false },
                    { data: 'action', orderable: false, searchable: false },
                ],
                order: [3, 'desc'],
                processing: true,
                serverSide: true
            });
            $('#datatable').on('draw.dt', function () { 
                enableDeleteButton();
            });
        </script>
    </x-slot>

</x-app-layout>