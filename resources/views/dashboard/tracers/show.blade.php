<x-app-layout>

    <x-slot name="pageHeading">
        <h1 class="h3 mb-0 text-gray-800">{{$title ?? ''}}</h1>
    </x-slot>

    {{-- <div class="row">
        <div class="col-lg-12">
            <a class="btn btn-primary" href="{{ route('tracers.index') }}"> Back</a>
        </div>
    </div> --}}

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Title:</strong>
                {{ $tracer->name }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Description:</strong>
                {{ $tracer->description }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Valid Until:</strong>
                {{ $tracer->valid_until->format('Y-m-d H:i:s') }}
            </div>
        </div>
    </div>
</x-app-layout>?
