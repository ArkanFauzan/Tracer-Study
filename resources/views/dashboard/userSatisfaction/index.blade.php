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

            <form action="{{ route('userSatisfaction.index') }}" method="POST">
                @csrf

                <div class="d-flex" style="column-gap: 20px">
                    <div class="form-group">
                        <select name="tracer_id">
                            <option value="" selected disabled>-- Pilih Tracer --</option>
                            <option value="1">Tracer 1</option>
                            <option value="2">Tracer 2</option>
                            <option value="3">Tracer 3</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="major_id">
                            <option value="" selected disabled>-- Pilih Major  --</option>
                            <option value="1">D3 - Akuntansi</option>
                            <option value="2">S1 - Teknik Informatika</option>
                            <option value="3">S2 - Magister Teknik Informatika</option>
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
                        <th>Sangat Tinggi</th>
                        <th>Tinggi</th>
                        <th>Cukup Tinggi</th>
                        <th>Rendah</th>
                        <th>Sangat Rendah</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Etika</td>
                        <td>93.73</td>
                        <td>6.27</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Kemampuan Bahasa Asing</td>
                        <td>62</td>
                        <td>4</td>
                        <td>4</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Kompetensi Bidang Ilmu</td>
                        <td>96.12</td>
                        <td>2.44</td>
                        <td>1.44</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>

                    <tr class="bg-primary text-white">
                        <td colspan="2">Rata-Rata</td>
                        <td>90.55</td>
                        <td>4.39</td>
                        <td>1.36</td>
                        <td>0</td>
                        <td>0</td>
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