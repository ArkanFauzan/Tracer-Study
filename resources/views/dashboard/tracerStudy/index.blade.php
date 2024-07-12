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

            <form action="{{ route('tracerStudy.index') }}" method="GET" class="mb-3">
                <div class="d-flex" style="column-gap: 20px">
                    <div class="form-group">
                        <select name="tracer_id">
                            <option value="" selected>-- Pilih Tracer --</option>
                            @foreach($tracers as $tracer)
                                <option value="{{$tracer->id}}" {{$tracer->id === $tracer_id ? 'selected' : ''}}>{{strtoupper($tracer->name)}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="major_id">
                            <option value="" selected>-- Pilih Major  --</option>
                            @foreach ($majorTypes as $majorType)
                                @foreach ($majorType->major as $major)
                                    <option value="{{$major->id}}" {{$major->id === $major_id ? 'selected' : ''}}>{{$majorType->name .' - '. $major->name}}</option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" style="height: 100%">Filter</button>
                    </div>
                </div>
            </form>

            <div class="w-50 p-3">
                <h3 class="text-center">Sebaran Target Responden Per Program Pendidikan</h3>
                <canvas id="sebaranTargetRespondenPerProgramPendidikan"></canvas>
            </div>

        </div>
    </div>

    <x-slot name="pageCSS">
        
    </x-slot>

    <x-slot name="pageScript">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            const CHART_COLORS = [
                'rgb(255, 99, 132)',
                'rgb(255, 159, 64)',
                'rgb(255, 205, 86)',
                'rgb(75, 192, 192)',
                'rgb(54, 162, 235)',
                'rgb(153, 102, 255)',
                'rgb(201, 203, 207)'
            ];
        </script>

        <script>
            const result = {!! json_encode($result) !!};

            const sebaranTargetRespondenPerProgramPendidikan = document.getElementById('sebaranTargetRespondenPerProgramPendidikan');
            new Chart(sebaranTargetRespondenPerProgramPendidikan, {
                type: 'pie',
                data: {
                    labels: result.sebaranTargetRespondenPerProgramPendidikan.labels,
                    datasets: [{
                        label: result.sebaranTargetRespondenPerProgramPendidikan.title,
                        data: result.sebaranTargetRespondenPerProgramPendidikan.data,
                        backgroundColor: CHART_COLORS,
                        hoverOffset: 4
                    }]
                },
            });
        </script>
    </x-slot>

</x-app-layout>