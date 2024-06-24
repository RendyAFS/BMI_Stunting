@extends('layouts.appnav')

@section('content')
    {{-- @include('layouts.navbar') --}}
    <section class="home-section mb-5">
        <div class="container mt-3 pt-3">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-6 col-md-7 col-12 mb-4">
                    <div class="card shadow">
                        <div class="card-header" id="calc-stunting">
                            <h1 class="card-title fs-3 fw-bold" id="examplecardLabel">Edit Data Bulanan Anak</h1>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('kaders.update', $dbulanans->id) }}" method="POST"
                                enctype="multipart/form-kaders" id="editForm">
                                @csrf
                                @method('PUT')
                                <h3 class="text-center">{{ $dbulanans->danaks->nama_anak }}</h3>
                                <h6 class="mb-4 text-center">{{ $dbulanans->created_at }}</h6>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-floating mb-3 d-none">
                                            <input type="text"
                                                class="form-control border border-dark-subtle @error('users_id') is-invalid @enderror"
                                                id="users_id" name="users_id" placeholder="Masukkan NIK" required
                                                maxlength="16" value="{{ Auth::user()->id }}">
                                            <label for="users_id" class="">User_id:</label>
                                            @error('users_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-floating mb-3 d-none">
                                            <input type="text" class="form-control " id="umur_periksa"
                                                name="umur_periksa" placeholder="Masukkan Umur"
                                                value="{{ $dbulanans->umur_periksa }}" required readonly>
                                            <label for="floatingInput" class="fw-bold">Umur:</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="st_anak" name="st_anak"
                                                placeholder="Status Anak" value="{{ $dbulanans->st_anak }}" required
                                                readonly
                                                style="color: {{ $dbulanans->st_anak === 'Normal'
                                                    ? 'mediumseagreen'
                                                    : ($dbulanans->st_anak === 'Pendek'
                                                        ? 'red'
                                                        : ($dbulanans->st_anak === 'Tinggi'
                                                            ? 'darkblue'
                                                            : 'defaultColor')) }};">
                                            <label for="st_anak" class="fw-bold">Status Anak:</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="gz_anak" name="gz_anak"
                                                placeholder="Status Anak" value="{{ $dbulanans->gz_anak }}" required
                                                readonly
                                                style="color: {{ $dbulanans->gz_anak === 'Normal' ? 'mediumseagreen' : ($dbulanans->gz_anak === 'Gizi Buruk' ? 'red' : ($dbulanans->gz_anak === 'Gizi Kurang' ? 'darkorange' : ($dbulanans->gz_anak === 'Kelebihan Berat Badan' ? 'darkblue' : ($dbulanans->gz_anak === 'Obesitas' ? 'black' : 'black')))) }}">

                                            <label for="st_anak" class="fw-bold">Gizi Anak:</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <select class="form-select" id="floatingSelectGrid" name="c_ukur"
                                                id="c_ukur">
                                                <option class="d-none" selected value="{{ $dbulanans->c_ukur }}">
                                                    {{ $dbulanans->c_ukur }}
                                                </option>
                                                <option value="Berdiri">Berdiri</option>
                                                <option value="Telentang">Telentang</option>
                                            </select>
                                            <label for="floatingSelectGrid" class="fw-bold">Cara Ukur</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control border border-0z   " id="bb_anak"
                                                name="bb_anak" placeholder="Masukkan Berat Badan (KG)"
                                                value="{{ $dbulanans->bb_anak }}" required>
                                            <label for="bb_anak" class="fw-bold">Berat Badan (KG):</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control border border-0z   " id="tb_anak"
                                                name="tb_anak" placeholder="Masukkan Tinggi Badan (CM)"
                                                value="{{ $dbulanans->tb_anak }}" required>
                                            <label for="tb_anak" class="fw-bold">Tinggi Badan (CM):</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control border border-0z " id="lk_anak"
                                                name="lk_anak" placeholder="Masukkan Lingkar Kepala (CM)"
                                                value="{{ $dbulanans->lk_anak }}" required>
                                            <label for="floatingInput" class="fw-bold">Lingkar Kepala (CM):</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control border border-0z " id="ll_anak"
                                                name="ll_anak" placeholder="Masukkan Lingkar Lengan (CM)"
                                                value="{{ $dbulanans->ll_anak }}" required>
                                            <label for="floatingInput" class="fw-bold">Lingkar Lengan (CM):</label>
                                        </div>
                                    </div>
                                </div>


                                {{-- d-none --}}
                                <div class="d-none">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control d-none" id="danaks_id"
                                            name="danaks_id" placeholder="Masukkan Nama Anak"
                                            value="{{ $dbulanans->danaks->id }}" required>
                                        <label for="floatingInput" class="fw-bold">Nama Anak:</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="created_at" name="created_at"
                                            placeholder="Masukkan created" value="{{ $dbulanans->created_at }}" required>
                                        <label for="floatingInput" class="fw-bold">created:</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control border border-0z " id="updated_at"
                                            name="updated_at" placeholder="Masukkan updated"
                                            value="{{ $dbulanans->updated_at }}" required>
                                        <label for="floatingInput" class="fw-bold">updated:</label>
                                    </div>
                                </div>

                                {{-- RUNUS BACKEND --}}
                                <input type="text" id="umur_tahun" name="umur_tahun" class="d-none" required
                                    placeholder="umur_tahun" value="{{ $dbulanans->umur_tahun }}">
                                <input type="text" id="umur_bulan" name="umur_bulan" class="d-none" required
                                    placeholder="umur_bulan" value="{{ $dbulanans->umur_bulan }}">
                                <input type="text" id="data-jk" name="data-jk" class="d-none" required
                                    placeholder="data-jk" value="{{ $dbulanans->danaks->jk }}">


                                {{-- GET URL --}}
                                <input class="form-control d-none" type="text" placeholder="id_posyandu"
                                    name="id_posyandu" id="id_posyandu" aria-label="id_posyandu"
                                    value="{{ $dbulanans->danaks->dposyandu_id }}">
                                <input class="form-control d-none" type="text" placeholder="nama_posyandu"
                                    name="nama_posyandu" id="nama_posyandu" aria-label="nama_posyandu"
                                    value="{{ $dbulanans->nama_posyandu }}">

                                <hr>
                                <div class="row d-flex justify-content-center pb-4">
                                    <div class="col-md-4 col-4 d-grid">
                                        <a href="javascript:void(0);" onclick="history.back();" id="batal"
                                            class="btn btn-danger shadow">
                                            Kembali
                                        </a>
                                    </div>
                                    <div class="col-md-4 col-3 d-grid">
                                        <button class="btn btn-success shadow">Edit</button>
                                    </div>
                                    <!-- Your form fields here -->
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" id="id_posyandu" name="id_posyandu"
                                        value="{{ $dbulanans->danaks->dposyandu_id }}">
                                    <input type="hidden" id="nama_posyandu" name="nama_posyandu"
                                        value="{{ $dbulanans->nama_posyandu }}">
                                </div>
                            </form>
                            <form action="{{ route('kaders.index') }}" method="get" id="filterForm">
                                <div class="d-flex flex-row mt-5 pt-5 d-none">
                                    <input class="form-control " type="text" placeholder="id_posyandu"
                                        name="id_posyandu" id="id_posyandu" aria-label=" id_posyandu">
                                    <input class="form-control " type="text" placeholder="nama_posyandu"
                                        name="nama_posyandu" id="nama_posyandu" aria-label="nama_posyandu">
                                </div>
                            </form>
                            <form action="{{ route('riwayatpostkader') }}" method="POST"
                                enctype="multipart/form-riwayat" id="riwayatForm" class="d-none">
                                @csrf
                                @method('PUT') <!-- Use the PUT method for editing -->
                                <input type="text" class="form-control " id="dbulans_id" name="dbulans_id"
                                    placeholder="dbulans_id" value="{{ $dbulanans->id }}" required readonly>
                                <input type="text" class="form-control " id="nama" name="nama"
                                    placeholder="Nama" value="{{ Auth::user()->name }}" required readonly>
                                <input type="text" class="form-control " id="aktivitas" name="aktivitas"
                                    placeholder="Aktivitas" value="Edit" required readonly>
                                <textarea class="form-control" id="data" name="data" rows="3" required readonly>{{ $dbulanans->danaks->nama_anak }} - {{ $dbulanans->umur_periksa }} - {{ $dbulanans->c_ukur }} - berat badan {{ $dbulanans->bb_anak }} kg - tinggi badan {{ $dbulanans->tb_anak }} cm - lingkar Kepala {{ $dbulanans->lk_anak }} cm - lingkar lengan {{ $dbulanans->ll_anak }} cm
                            </textarea>
                                <button class="btn btn-success shadow">Edit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <script>
            $(document).ready(function() {
                // Intercept the submit event of the first form
                $("#editForm").submit(function(event) {
                    // Prevent the default form submission
                    event.preventDefault();

                    // Serialize the form data
                    var editFormData = $(this).serialize();

                    // Perform the form submission using AJAX
                    $.ajax({
                        url: $(this).attr("action"),
                        method: $(this).attr("method"),
                        data: editFormData,
                        success: function(data) {
                            // If the first form submission is successful, serialize and submit the second form
                            var riwayatFormData = $("#riwayatForm").serialize();

                            $.ajax({
                                url: $("#riwayatForm").attr("action"),
                                method: $("#riwayatForm").attr("method"),
                                data: riwayatFormData,
                                success: function(data) {
                                    // If the second form submission is successful, serialize and submit the third form
                                    var filterFormData = $("#filterForm").serialize();

                                    var token = $('input[name="_token"]').val();
                                    var idPosyandu = $('#id_posyandu').val();
                                    var namaPosyandu = $('#nama_posyandu').val();

                                    // Construct the URL with the necessary parameters
                                    var filterFormUrl = $("#filterForm").attr(
                                            "action") + "?_token=" + token +
                                        "&id_posyandu=" + idPosyandu +
                                        "&nama_posyandu=" + namaPosyandu;

                                    // Perform the GET request
                                    window.location.href = filterFormUrl;
                                },
                                error: function(error) {
                                    console.error("Error submitting riwayatForm: ",
                                        error);
                                    // Handle errors if needed
                                }
                            });
                        },
                        error: function(error) {
                            console.error("Error submitting editForm: ", error);
                            // Handle errors if needed
                        }
                    });
                });
            });


            document.addEventListener("DOMContentLoaded", function() {
                // Mendapatkan referensi ke elemen input
                let bb_anakInput = document.getElementById('bb_anak');
                let tb_anakInput = document.getElementById('tb_anak');
                let lk_anakInput = document.getElementById('lk_anak');
                let ll_anakInput = document.getElementById('ll_anak');
                let umurInputt = document.getElementById('umur_tahun');
                let st_anakInput = document.getElementById('st_anak');
                let jkValue = document.getElementById('data-jk').value; // Ambil nilai dari elemen

                // Tambahkan event listener ke setiap input untuk memanggil fungsi updateStatusAnak saat ada perubahan
                bb_anakInput.addEventListener('input', updateStatusAnak);
                tb_anakInput.addEventListener('input', updateStatusAnak);
                lk_anakInput.addEventListener('input', updateStatusAnak);
                ll_anakInput.addEventListener('input', updateStatusAnak);

                function updateStatusAnak() {
                    let bb_anakValue = parseFloat(bb_anakInput.value);
                    let tb_anakValue = parseFloat(tb_anakInput.value);
                    let lk_anakValue = parseFloat(lk_anakInput.value);
                    let ll_anakValue = parseFloat(ll_anakInput.value);
                    let ut_anakValue = parseFloat(umurInputt.value);

                    if (!isNaN(bb_anakValue) && !isNaN(tb_anakValue) && !isNaN(lk_anakValue) && !isNaN(ll_anakValue)) {
                        // let st_anakValue = lk_anakValue + ll_anakValue;
                        let tinggiMeter = tb_anakValue / 100; // Ubah tinggi ke meter
                        let imt = bb_anakValue / (tinggiMeter * tinggiMeter); //mencari Indeks masa tubuh

                        if (ut_anakValue < 5) {
                            if (jkValue === 'L') {
                                if (imt < 9) {
                                    st_anakInput.value = "Bawah Garis Merah";
                                    imt_anakInput.value = imt;
                                } else if (imt >= 9 && imt < 11) {
                                    st_anakInput.value = 'Gizi Kurang';
                                    imt_anakInput.value = imt;
                                } else if (imt >= 11 && imt < 19) {
                                    st_anakInput.value = 'Normal';
                                    imt_anakInput.value = imt;
                                } else if (imt >= 19 && imt < 33) {
                                    st_anakInput.value = 'Kelebihan Berat Badan';
                                    imt_anakInput.value = imt;
                                } else {
                                    st_anakInput.value = 'Obesitas';
                                    imt_anakInput.value = imt;
                                }
                            } else if (jkValue === 'P') {
                                if (imt < 9) {
                                    st_anakInput.value = "Bawah Garis Merah";
                                    imt_anakInput.value = imt;
                                } else if (imt >= 9 && imt < 11) {
                                    st_anakInput.value = 'Gizi Kurang';
                                    imt_anakInput.value = imt;
                                } else if (imt >= 11 && imt < 19) {
                                    st_anakInput.value = 'Normal';
                                    imt_anakInput.value = imt;
                                } else if (imt >= 19 && imt < 33) {
                                    st_anakInput.value = 'Kelebihan Berat Badan';
                                    imt_anakInput.value = imt;
                                } else {
                                    st_anakInput.value = 'Obesitas';
                                    imt_anakInput.value = imt;
                                }
                            }
                        } else {
                            if (imt < 10) {
                                st_anakInput.value = 'Gizi Buruk';
                            } else if (imt >= 10 && imt < 25) {
                                st_anakInput.value = 'Normal';
                            } else if (imt >= 25 && imt < 30) {
                                st_anakInput.value = 'Kelebihan Berat Badan';
                            } else {
                                st_anakInput.value = 'Obesitas';
                            }
                        }
                        imt_anakInput.value = imt.toFixed(2);
                    } else {
                        st_anakInput.value = '- Inputan Tidak Valid';
                    }
                }
            });
        </script>


    </section>
@endsection
