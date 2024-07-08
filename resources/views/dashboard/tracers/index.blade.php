<x-app-layout>

    <x-slot name="pageHeading">
        <h1 class="h3 mb-0 text-gray-800">{{$title ?? ''}}</h1>
    </x-slot>

    <div class="row">
        <div class="col-lg-12 mb-4">
            <a class="btn btn-success" href="{{ route('tracers.create') }}">Create New Tracer</a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 mb-4">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
            <table class="table table-bordered">
                <tr>
                    <th>No</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Valid Until</th>
                    <th>Form Link</th>
                    <th width="180px">Action</th> <!-- Lebar kolom dikurangi karena ikon lebih kecil -->
                </tr>
                @php $i = 0; @endphp
                @foreach ($tracers as $tracer)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $tracer->name }}</td>
                    <td>{{ $tracer->description }}</td>
                    <td>{{ $tracer->valid_until }}</td>
                    <td>
                        <a class="btn btn-info btn-sm" href="{{ route('form.tracerStudy', $tracer->id) }}" target="_blank" title="Form Tracer Study">Form Tracer Study</a> <br><br>
                        <a class="btn btn-info btn-sm" href="{{ route('form.tracerStudy', $tracer->id) }}" target="_blank" title="Form User Satisfaction">Form User Satisfaction</a>
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

    <x-slot name="pageScript">
        <script>
            let deleteBtns = document.querySelectorAll(".button-delete");
            if (deleteBtns) {
                for (let i = 0; i < deleteBtns.length; i++) {
                    deleteBtns[i].addEventListener('click', function(e){
                        e.preventDefault();
                        const {text} = e.target.dataset;
                        const confirm = window.confirm(`Do you want to delete "${text}"`);
                        if (confirm) {
                            e.target.parentNode.submit();
                        }
                    })
                }
            }
        </script>
    </x-slot>

</x-app-layout>