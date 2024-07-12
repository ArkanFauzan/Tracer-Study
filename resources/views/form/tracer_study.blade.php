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
        <div style="width: 820px">
            <form action="{{ route('form.tracerStudyStore') }}" method="POST">
                @csrf
    
                <input type="hidden" name="tracer_id" value="{{$tracer->id}}">
    
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <br>
                        <h6 class="h6 mb-0 text-gray-800" style="font-weight: bold">A. Profil Responden</h6>
                        <br>
                    </div>
                </div>
    
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label style="display: inline-block; margin-bottom:10px">Jurusan?</label> <br>
                            <select name="major_id" required class="w-50">
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
    
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            @php
                                $id = '1897cfad-9b30-47aa-b7bc-257b262983d2'; // Tahun kelulusan?
                            @endphp
                            <label style="display: inline-block; margin-bottom:10px">{{$questions[$id]['question']}}</label> <br>
                            <input type="number" min="1990" max="{{date('Y')}}" class="form-control w-50" name="{{$id}}" placeholder="" required>
                        </div>
    
                        <div class="form-group">
                            @php
                                $id = 'a34de7b6-f2c6-408c-ac7f-4c6601d0edcf'; // IPK kelulusan?
                            @endphp
                            <label style="display: inline-block; margin-bottom:10px">{{$questions[$id]['question']}}</label> <br>
                            <input type="number" min="1.00" max="4.00" step=".01" class="form-control w-50" name="{{$id}}" placeholder="" required>
                        </div>
    
                        <div class="form-group">
                            @php
                                $id = 'b3ea5c8a-1ddc-43e8-bbb3-83d90498a499'; // Lama studi?
                            @endphp
                            <label style="display: inline-block; margin-bottom:10px">{{$questions[$id]['question']}} (tahun)</label> <br>
                            <input type="number" min="1" max="8" step=".1" class="form-control w-50" name="{{$id}}" placeholder="" required>
                        </div>
    
                        <div class="form-group">
                            @php
                                $id = '564cec47-e003-47ff-b010-4b923c42d18f'; // Pekerjaan?
                            @endphp
                            <label style="display: inline-block; margin-bottom:10px">{{$questions[$id]['question']}}</label> <br>
                            @foreach ($questions[$id]['questionOptions'] as $option)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="{{$id}}" value="{{$option->id}}" id="id-{{$id}}-{{$option->id}}" required>
                                    <label class="form-check-label" for="id-{{$id}}-{{$option->id}}">
                                        {{$option->option}}
                                    </label>
                                </div>
                            @endforeach
                        </div>
    
                        <div class="form-group">
                            @php
                                $id = 'b6d3916a-4bd3-43c0-8b89-aecd0af3a014'; // Jenis tempat bekerja?
                            @endphp
                            <label style="display: inline-block; margin-bottom:10px">{{$questions[$id]['question']}}</label> <br>
                            @foreach ($questions[$id]['questionOptions'] as $option)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="{{$id}}" value="{{$option->id}}" id="id-{{$id}}-{{$option->id}}" required>
                                    <label class="form-check-label" for="id-{{$id}}-{{$option->id}}">
                                        {{$option->option}}
                                    </label>
                                </div>
                            @endforeach
                        </div>
    
                        <div class="form-group">
                            @php
                                $id = '8f034dbb-7121-4ce7-a889-a8456b7335aa'; // Level tempat bekerja?
                            @endphp
                            <label style="display: inline-block; margin-bottom:10px">{{$questions[$id]['question']}}</label> <br>
                            @foreach ($questions[$id]['questionOptions'] as $option)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="{{$id}}" value="{{$option->id}}" id="id-{{$id}}-{{$option->id}}" required>
                                    <label class="form-check-label" for="id-{{$id}}-{{$option->id}}">
                                        {{$option->option}}
                                    </label>
                                </div>
                            @endforeach
                        </div>
    
                        {{-- show if pekerjaan = bekerja --}}
                        <div id="profil-waktu-tunggu-bekerja" data-question-id="564cec47-e003-47ff-b010-4b923c42d18f" data-option-id="0ed9d36f-31af-4e20-a63c-dd3440c60a15">
    
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <br>
                                    <h6 class="h6 mb-0 text-gray-800" style="font-weight: bold">B. Profil Waktu Tunggu (Bekerja, Bukan Wirausaha)</h6>
                                    <br>
                                </div>
                            </div>
    
                            <div class="form-group">
                                @php
                                    $id = 'f8ca2b1f-2bbd-49b0-abaa-adaffd03635e'; // Kapan mulai mencari pekerjaan?
                                @endphp
                                <label style="display: inline-block; margin-bottom:10px">{{$questions[$id]['question']}}</label> <br>
                                @foreach ($questions[$id]['questionOptions'] as $option)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="{{$id}}" value="{{$option->id}}" id="id-{{$id}}-{{$option->id}}" required>
                                        <label class="form-check-label" for="id-{{$id}}-{{$option->id}}">
                                            {{$option->option}}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
        
                            <div class="form-group">
                                @php
                                    $id = '40be258c-2ac6-4f39-8105-0a45aa999e14'; // Berapa banyak perusahaan/institusi yang sudah dilamar untuk mendapatkan pekerjaan pertama?
                                @endphp
                                <label style="display: inline-block; margin-bottom:10px">{{$questions[$id]['question']}}</label> <br>
                                @foreach ($questions[$id]['questionOptions'] as $option)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="{{$id}}" value="{{$option->id}}" id="id-{{$id}}-{{$option->id}}" required>
                                        <label class="form-check-label" for="id-{{$id}}-{{$option->id}}">
                                            {{$option->option}}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
        
                            <div class="form-group">
                                @php
                                    $id = 'ea0daa51-252e-40a4-9f87-f9aba63dbe66'; // Bagaimana cara mencari pekerjaan tersebut?
                                @endphp
                                <label style="display: inline-block; margin-bottom:10px">{{$questions[$id]['question']}}</label> <br>
                                @foreach ($questions[$id]['questionOptions'] as $option)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="{{$id}}" value="{{$option->id}}" id="id-{{$id}}-{{$option->id}}" required>
                                        <label class="form-check-label" for="id-{{$id}}-{{$option->id}}">
                                            {{$option->option}}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
        
                            <div class="form-group">
                                @php
                                    $id = '0d03fd59-0b66-4572-8cca-8025deae17d7'; // Berapa banyak yang merespon lamaran?
                                @endphp
                                <label style="display: inline-block; margin-bottom:10px">{{$questions[$id]['question']}}</label> <br>
                                @foreach ($questions[$id]['questionOptions'] as $option)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="{{$id}}" value="{{$option->id}}" id="id-{{$id}}-{{$option->id}}" required>
                                        <label class="form-check-label" for="id-{{$id}}-{{$option->id}}">
                                            {{$option->option}}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
        
                            <div class="form-group">
                                @php
                                    $id = '213f20f0-3c86-4e03-85cd-45e324e66e4b'; // Berapa bulan waktu yang dihabiskan (sebelum dan sesudah kelulusan) untuk memeroleh pekerjaan pertama?
                                @endphp
                                <label style="display: inline-block; margin-bottom:10px">{{$questions[$id]['question']}}</label> <br>
                                @foreach ($questions[$id]['questionOptions'] as $option)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="{{$id}}" value="{{$option->id}}" id="id-{{$id}}-{{$option->id}}" required>
                                        <label class="form-check-label" for="id-{{$id}}-{{$option->id}}">
                                            {{$option->option}}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
        
                            <div class="form-group">
                                @php
                                    $id = 'c16509bb-1862-42ae-9448-91a8a5bf4aa9'; // Seberapa erat hubungan bidang studi dengan pekerjaan/bidang wirausaha?
                                @endphp
                                <label style="display: inline-block; margin-bottom:10px">{{$questions[$id]['question']}}</label> <br>
                                @foreach ($questions[$id]['questionOptions'] as $option)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="{{$id}}" value="{{$option->id}}" id="id-{{$id}}-{{$option->id}}" required>
                                        <label class="form-check-label" for="id-{{$id}}-{{$option->id}}">
                                            {{$option->option}}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
        
                            <div class="form-group">
                                @php
                                    $id = 'c129b105-231a-4e82-afc5-af77a443bb83'; // Apakah bidang pekerjaan/wirausaha sesuai dengan kompetensi akademik?
                                @endphp
                                <label style="display: inline-block; margin-bottom:10px">{{$questions[$id]['question']}}</label> <br>
                                @foreach ($questions[$id]['questionOptions'] as $option)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="{{$id}}" value="{{$option->id}}" id="id-{{$id}}-{{$option->id}}" required>
                                        <label class="form-check-label" for="id-{{$id}}-{{$option->id}}">
                                            {{$option->option}}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
    
                        </div>
    
                        {{-- show if pekerjaan = wirausaha --}}
                        <div id="profil-waktu-tunggu-wirausaha" data-question-id="564cec47-e003-47ff-b010-4b923c42d18f" data-option-id="71ae9822-7c5a-4e21-826b-75a3f73c7023">
    
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <br>
                                    <h6 class="h6 mb-0 text-gray-800" style="font-weight: bold">B. Profil Waktu Tunggu (Wirausaha)</h6>
                                    <br>
                                </div>
                            </div>
    
                            <div class="form-group">
                                @php
                                    $id = '8c156dc9-348e-41c1-891b-a9d523a22561'; // Sejak kapan memiliki keinginan berwirausaha?
                                @endphp
                                <label style="display: inline-block; margin-bottom:10px">{{$questions[$id]['question']}}</label> <br>
                                @foreach ($questions[$id]['questionOptions'] as $option)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="{{$id}}" value="{{$option->id}}" id="id-{{$id}}-{{$option->id}}" required>
                                        <label class="form-check-label" for="id-{{$id}}-{{$option->id}}">
                                            {{$option->option}}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
        
                            @php
                                $id = '9f5c6968-f17a-4a83-b05c-ca67d1e39a22'; // Apa alasan memutuskan untuk berwirausaha? (boleh lebih dari 1, paling banyak 2)
                            @endphp
                            <div class="form-group" id="checkbox-{{$id}}">
                                <label style="display: inline-block; margin-bottom:10px">{{$questions[$id]['question']}}</label> <br>
                                @foreach ($questions[$id]['questionOptions'] as $option)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="{{$id}}[]" value="{{$option->id}}" id="id-{{$id}}-{{$option->id}}">
                                        <label class="form-check-label" for="id-{{$id}}-{{$option->id}}">
                                            {{$option->option}}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
    
                        </div>
                    </div>
                </div>
    
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" id="btnSubmit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    @endif

    <x-slot name="pageScript">
        <script>

            let waitingTimeWork = document.getElementById('profil-waktu-tunggu-bekerja');
            let waitingTimeWorkHTML = waitingTimeWork.innerHTML;
            waitingTimeWork.innerHTML = '';

            let waitingTimeEntrepreneur = document.getElementById('profil-waktu-tunggu-wirausaha');
            let waitingTimeEntrepreneurHTML = waitingTimeEntrepreneur.innerHTML;
            waitingTimeEntrepreneur.innerHTML = '';

            let questionId = '';
            let optionsIds = [];

            // listen selected option
            if (waitingTimeWork.dataset.optionId) {
                let id = waitingTimeWork.dataset.optionId;

                questionId = waitingTimeWork.dataset.questionId;
                optionsIds.push(id);

                let el = document.querySelector(`input[value="${id}"]`)
                if (el) {
                    el.addEventListener('change', function(e){
                        if (e.target.checked) {
                            waitingTimeWork.innerHTML = waitingTimeWorkHTML; // show form
                            waitingTimeEntrepreneur.innerHTML = '';
                        }
                        else {
                            waitingTimeWork.innerHTML = ''; // hide form
                        }
                    });
                }
            }

            // listen selected option
            if (waitingTimeEntrepreneur.dataset.optionId) {
                let id = waitingTimeEntrepreneur.dataset.optionId;

                optionsIds.push(id);

                let el = document.querySelector(`input[value="${id}"]`)
                if (el) {
                    el.addEventListener('change', function(e){
                        if (e.target.checked) {
                            waitingTimeEntrepreneur.innerHTML = waitingTimeEntrepreneurHTML; // show form
                            waitingTimeWork.innerHTML = '';
                        }
                        else {
                            waitingTimeEntrepreneur.innerHTML = ''; // hide form
                        }
                    });
                }
            }

            // unchecked (hide all form) when select other option
            if (questionId && optionsIds.length > 0) {
                let options = document.querySelectorAll(`input[name="${questionId}"]`);
                for (let i = 0; i < options.length; i++) {
                    if (! optionsIds.includes(options[i].value)) {
                        options[i].addEventListener('change', function(e){
                            waitingTimeWork.innerHTML = '';
                            waitingTimeEntrepreneur.innerHTML = '';
                        });
                    }
                }
            }

            function checkMinMaxCheckbox(id, min, max){
                let container = document.getElementById(id);

                if (container) {
                    let count = 0;
                    let checkboxs = document.querySelectorAll(`#${id} input[type="checkbox"]`);
                    for (let i = 0; i < checkboxs.length; i++) {
                        if (checkboxs[i].checked) {
                            count++;
                        }
                    }
                    return min <= count && count <= max;
                }


                return true;
            }

            // process submit
            let successCustomValidation = false;
            $('#btnSubmit').on('click', function(e) {

                if (successCustomValidation) {
                    successCustomValidation = false;// reset flag
                    return; // let the event bubble away
                }

                e.preventDefault();

                let valid = checkMinMaxCheckbox('checkbox-9f5c6968-f17a-4a83-b05c-ca67d1e39a22', 1, 2);

                if (!valid) {
                    alert('Alasan berwirausaha harus dipilih! (min 1, max 2)');
                }
                else {
                    successCustomValidation = true; // set flag
                    $(this).trigger('click');
                }

            });

        </script>
    </x-slot>
    
</x-guest-layout>
