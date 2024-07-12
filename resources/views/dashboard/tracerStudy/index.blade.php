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

            <div class="d-flex justify-content-center">
                <div class="w-50 p-3 text-center">
                    <h3 class="text-center">Sebaran Target Responden Per Program Pendidikan</h3>
                    <canvas id="sebaranTargetRespondenPerProgramPendidikan"></canvas>
                </div>
            </div>
            <div class="w-100 p-3 mt-5">
                <h3 class="text-center">Sebaran Responden yang Memberikan Jawaban</h3>
                <canvas id="sebaranRespondenYangMemberikanJawaban"></canvas>
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

            // Chart.defaults.global.maintainAspectRatio = false;

            const sebaranTargetRespondenPerProgramPendidikan = document.getElementById('sebaranTargetRespondenPerProgramPendidikan');
            new Chart(sebaranTargetRespondenPerProgramPendidikan, {
                type: 'pie',
                data: {
                    labels: result.sebaranTargetRespondenPerProgramPendidikan.labels,
                    datasets: [{
                        label: 'Jumlah',
                        data: result.sebaranTargetRespondenPerProgramPendidikan.data,
                        backgroundColor: CHART_COLORS,
                        hoverOffset: 4
                    }]
                },
            });

            const sebaranRespondenYangMemberikanJawaban = document.getElementById('sebaranRespondenYangMemberikanJawaban');
            new Chart(sebaranRespondenYangMemberikanJawaban, {
                type: 'bar',
                data: {
                    labels: result.sebaranRespondenYangMemberikanJawaban.labels,
                    datasets: [{
                        label: 'Data',
                        data: result.sebaranRespondenYangMemberikanJawaban.data,
                        borderColor: 'rgb(255, 99, 132)',
                        backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    }]
                },
                options: {
                    indexAxis: 'y',
                    // Elements options apply to all of the options unless overridden in a dataset
                    // In this case, we are setting the border of each horizontal bar to be 2px wide
                    elements: {
                        bar: {
                            borderWidth: 2,
                        }
                    },
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'right',
                        },
                        title: {
                            display: false,
                            text: result.sebaranRespondenYangMemberikanJawaban.title
                        }
                    }
                },
            });
        </script>
    </x-slot>

</x-app-layout>