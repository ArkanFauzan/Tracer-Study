<x-app-layout>

    <x-slot name="pageHeading">
        <h1 class="h3 mb-0 text-gray-800">{{$title ?? ''}}</h1>
    </x-slot>

    <div class="row">
        <div class="col-lg-12">
            {{-- <a class="btn btn-success" href="{{ route('tracers.create') }}">Create New Tracer</a> --}}
        </div>
    </div>
    <div class="row" style="background-color:white">
        <div class="col-lg-12 mb-4 pt-4">

            <form action="{{ route('userSatisfaction.index') }}" method="GET">

                <div class="d-flex" style="column-gap: 20px">
                    <div class="form-group">
                        <select name="tracer_id">
                            <option value="" selected>-- Pilih Tracer --</option>
                            @foreach($tracers as $tracer)
                                <option value="{{$tracer->id}}" {{$tracer->id === $tracer_id ? 'selected' : ''}}>{{$tracer->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="major_id">
                            <option value="" selected>-- Pilih Major  --</option>
                            @foreach ($majorTypes as $majorType)
                                @foreach ($majorType->major as $major)
                                    <option value="{{$major->id}}">{{$majorType->name .' - '. $major->name}}</option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" style="height: 100%">Filter</button>
                    </div>
                </div>
            </form>

            <table class="table table-bordered">
                <thead>
                    <tr class="bg-primary text-white">
                        <th>No</th>
                        <th>Indicator</th>
                        @foreach($result['optionsPercentage'] as $val)
                            <th class="text-center">{{$val['option']}}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($result['indicators'] as $indicator_id => $indicatorName)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{$indicatorName}}</td>
                            @foreach($result['optionsPercentage'] as $val)
                                <th class="text-center">{{$val['data'][$indicator_id]}} %</th>
                            @endforeach
                        </tr>
                    @endforeach

                    <tr class="bg-primary text-white">
                        <td colspan="2">Rata-Rata</td>
                        @foreach($result['optionsPercentage'] as $val)
                            <th class="text-center">{{$val['average']}} %</th>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <x-slot name="pageCSS">
        
    </x-slot>

    <x-slot name="pageScript">
        
    </x-slot>

</x-app-layout>