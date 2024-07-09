<x-guest-layout>

    <x-slot name="pageHeading">
        <h1 class="h3 mb-0 text-gray-800">{{$title ?? ''}}</h1>
    </x-slot>

    @if(!empty($invalidForm))
        <div class="alert alert-danger">
            <strong>Invalid form or form has been expired!</strong>
        </div>
    @else
        <form action="{{ route('tracers.store') }}" method="POST">
            @csrf

            @foreach ($questions as $question)
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong style="display: inline-block; margin-bottom:10px">{{$question->name}}?</strong> <br>
                            @foreach ($options as $option)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="{{$question->id}}" value="{{$option->id}}" id="id-{{$question->id}}-{{$option->id}}" required>
                                    <label class="form-check-label" for="id-{{$question->id}}-{{$option->id}}">
                                        {{$option->option}}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </form>
    @endif
    
</x-guest-layout>
