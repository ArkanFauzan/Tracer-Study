<x-app-layout>

    <x-slot name="pageHeading">
        <h1 class="h3 mb-0 text-gray-800">{{$title ?? ''}}</h1>
    </x-slot>

    {{-- <div class="row">
        <div class="col-lg-12">
            <a class="btn btn-primary" href="{{ route('tracers.index') }}"> Back</a>
        </div>
    </div> --}}

    @if ($errors->any())
        <div class="alert alert-danger">
            There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tracers.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Title:</strong>
                    <input type="text" name="name" maxlength="250" class="form-control" required placeholder="Title">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Description:</strong>
                    <textarea name="description" maxlength="250" class="form-control"></textarea>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Valid Until:</strong>
                    <input type="date" name="valid_until" class="form-control" placeholder="Valid until" required min="{{date('Y-m-d')}}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>

    </form>
</x-app-layout>