<x-guest-layout>

    <x-slot name="pageHeading">
        <h1 class="h3 mb-0 text-gray-800">{{$title ?? ''}}</h1>
    </x-slot>

    @if(!empty($invalidForm))
        <div class="alert alert-danger">
            <strong>Invalid form or form has been expired!</strong>
        </div>
    @elseif(Session('success'))
        <div class="alert alert-success">
            <strong>Form has been submitted, thank you!</strong>
        </div>
    @else
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
        <form action="{{ route('form.userSatisfactionStore') }}" method="POST">
            @csrf

            <input type="hidden" name="tracer_id" value="{{$tracer->id}}">

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong style="display: inline-block; margin-bottom:10px">Jurusan?</strong> <br>
                        <select name="major_id" required>
                            <option value="" selected disabled>-- Pilih --</option>
                            @foreach ($majorTypes as $majorType)
                                @foreach ($majorType->major as $major)
                                    <option value="{{$major->id}}">{{$majorType->name .' - '. $major->name}}</option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

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
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    @endif
    
</x-guest-layout>
