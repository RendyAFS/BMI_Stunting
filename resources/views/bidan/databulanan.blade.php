@extends('layouts.appnav')

@section('content')
    @include('layouts.navbar')
    <section class="home-section mb-5">
        <div class="content">
            <div class="container mt-3 pt-3">
                <div class="row justify-content-center">
                    <h1 class="fw-bold h mb-4">Halaman Data Bulanan</h1>
                    <div class="col-12 col-lg-6 mb-5 d-flex">
                        <form action="{{ route('dbulanans.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card shadow">
                                <div class="card-header" id="calc-stunting">
                                    <h3 class="fw-bold">Input Data</h3>
                                </div>

                                <div class="card-body">
                                    <div class="d-flex ">
                                        <i class="bi bi-search fs-3 me-2"></i>
                                        <input type="text" id="searchInput"
                                            class="form-control mb-3 border border-dark-subtle" placeholder="Cari Nama"
                                            onclick="selectAllText(this);" onfocus="selectAllText(this);">
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <select class="form-select mb-2" size="7" id="danaks_id" name="danaks_id"
                                                required style="cursor: pointer">
                                                <option class="fw-bold fs-5 mb-3 text-center bg-dark-subtle rounded-2"
                                                    value="null" disabled>
                                                    Silahkan Pilih Nama
                                                </option>

                                                @foreach ($danaks->sortBy('nama_anak') as $data)
                                                    @php
                                                        $tanggal_lahir = new DateTime($data->tanggal_lahir);
                                                        $sekarang = new DateTime();
                                                        $umur = $tanggal_lahir->diff($sekarang);

                                                        $umurTotal = $umur->y;
                                                        $umurTotal2 = $umur->m;
                                                        $umurTotal3 = $umur->y . ' Tahun ' . $umur->m . ' Bulan';
                                                    @endphp
                                                    <option
                                                        class="border border-dark-subtle mb-2 px-2 overflow-auto overflow-md-hidden"
                                                        value="{{ $data->id }}" {{-- untuk rumus stunting --}}
                                                        data-jk="{{ $data->jk }}"
                                                        data-nama_posyandu="{{ $data->dposyandu->nama_posyandu }}"
                                                        data-umur="{{ $umurTotal }}" data-umur2="{{ $umurTotal2 }}"
                                                        data-umur3="{{ $umurTotal3 }}"> <!-- Menambahkan data-umur -->
                                                        - {{ $data->nama_anak }} | {{ $data->nik_anak }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        {{-- Cara Ukur --}}
                                        <div class="mb-3 d-flex justify-content-center align-items-center">
                                            <form>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input border border-dark" type="radio" required
                                                        id="berdiriCheckbox" name="postureCheckbox"
                                                        value="Berdiri">
                                                    <label class="form-check-label fw-bold"
                                                        for="berdiriCheckbox">Berdiri</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input border border-dark" type="radio" required
                                                        id="telentangCheckbox" name="postureCheckbox"
                                                        value="Telentang">
                                                    <label class="form-check-label fw-bold"
                                                        for="telentangCheckbox">Telentang</label>
                                                </div>
                                            </form>
                                        </div>
                                        {{-- Cara Ukur --}}
                                        <div class="col-6">
                                            {{-- Untuk Umur Periksa --}}
                                            <input type="text" id="umur_tahun" name="umur_tahun" class="d-none" required
                                                placeholder="umur_tahun">
                                            <input type="text" id="umur_bulan" name="umur_bulan" class="d-none" required
                                                placeholder="umur_bulan">
                                            <input type="text" id="umur_periksa" name="umur_periksa" class="d-none"
                                                required placeholder="umur_periksa">
                                            <input type="text" id="nama_posyandu" name='nama_posyandu' class="d-none"
                                                required placeholder="nama_posyandu">
                                            <input type="text" id="c_ukur" name='c_ukur' class="d-none" required
                                                placeholder="c_ukur">

                                            <div class="form-floating mb-3">
                                                <input type="number" class="form-control border border-dark-subtle"
                                                    id="bb_anak" name="bb_anak" placeholder="Masukan Berat Badan (KG)"
                                                    value="0" required onclick="selectAllText(this);"
                                                    onfocus="selectAllText(this);">
                                                <label class="d-md-block d-none" for="bb_anak">Berat Badan (KG)</label>
                                                <label class="d-md-none d-block" for="bb_anak">Berat Badan</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-floating mb-3">
                                                <input type="number" class="form-control border-dark-subtle" id="tb_anak"
                                                    name="tb_anak" placeholder="Masukan Tinggi Badan (KG)" value="0"
                                                    required onclick="selectAllText(this);"
                                                    onfocus="selectAllText(this);">
                                                <label class="d-md-block d-none" for="tb_anak">Tinggi Badan (CM)</label>
                                                <label class="d-md-none d-block" for="tb_anak">Tinggi Badan</label>
                                            </div>
                                        </div>
                                        {{-- LIla --}}
                                        <div class="col-6">
                                            <div class="form-floating mb-3">
                                                <input type="number" class="form-control border border-dark-subtle"
                                                    id="lk_anak" name="lk_anak"
                                                    placeholder="Masukan Lingkar Kepala (CM)" value="0" required
                                                    onclick="selectAllText(this);" onfocus="selectAllText(this);">
                                                <label class="d-md-block d-none" for="lk_anak">Lingkar Kepala
                                                    (CM)</label>
                                                <label class="d-md-none d-block" for="lk_anak">Lingkar Kepala</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-floating mb-3">
                                                <input type="number" class="form-control border-dark-subtle"
                                                    id="ll_anak" name="ll_anak"
                                                    placeholder="Masukan Lingkar Lengan (CM)" value="0" required
                                                    onclick="selectAllText(this);" onfocus="selectAllText(this);">
                                                <label class="d-md-block d-none" for="ll_anak">Lingkar Lengan
                                                    (CM)</label>
                                                <label class="d-md-none d-block" for="ll_anak">Lingkar Lengan</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control border-dark-subtle"
                                                    id="st_anak" name="st_anak" placeholder="Status Anak" required
                                                    readonly value="- Silahkan Masukan Data">
                                                <label for="st_anak">Status Aanak</label>
                                            </div>
                                        </div>
                                    </div>


                                    {{-- Button --}}
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-md-3 col-4 d-grid">
                                            <a id="reset" class="btn btn-danger shadow">Reset</a>
                                        </div>
                                        <div class="col-md-3 col-4 d-grid">
                                            <button class="btn btn-success shadow">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- BADEGE POSYANDU --}}
                    <div class="col-12 col-lg-6 mb-4">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-list-ol fs-4 me-2"></i>
                            <h2>Antrian</h2>
                        </div>
                        <div class="mt-2 px-1">
                            <div class="mb-2">
                                {{-- <h6>Silahkan Pilih Posyandu: </h6> --}}
                                @foreach ($dposyandu as $data)
                                    <button class="badge ku" onclick="tampilkanTabel(this)">
                                        {{ $data->nama_posyandu }}
                                    </button>
                                @endforeach
                            </div>
                            <table id="tabel_antrian" class="table table-bordered shadow"
                                style="width:100%; display: none;">
                                <thead class="table-warning">
                                    <tr>
                                        <th>id</th>
                                        <th id="th">Urutan</th>
                                        <th id="th" class="w-50">Nama</th>
                                        <th id="th" class="w-50">Posyandu</th>
                                        <th id="th" class="w-50">Opsi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>


                    {{-- TABEL BULANAN --}}
                    <div class="col-12">
                        <div class="row align-items-center mb-5">
                            <div class="col-lg-4 col-md-6 col-12 mb-2">
                                <h2 class="d-block mt-2" id="totabel"> Tabel Bulanan:</h2>

                            </div>
                            <div class="col-lg-8 col-md-6 col-12 d-flex justify-content-md-end">
                                <form action="{{ route('exportbulanan') }}" method="GET">
                                    <form action="{{ route('exportbulanan') }}" method="GET">
                                        <select name="nama_posyandu"
                                            class="select_posyandu form-select me-4 border border-dark mb-2">
                                            <option value="null" selected disabled>Pilih Posyandu</option>
                                            @foreach ($dposyandu->sortBy('nama_posyandu') as $posyandu)
                                                <option value="{{ $posyandu->nama_posyandu }}">
                                                    {{ $posyandu->nama_posyandu }}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="btn btn-success w-100 shadow" id="downloadButton"
                                            disabled>
                                            <i class="bi bi-file-earmark-spreadsheet"></i> Download
                                        </button>
                                    </form>
                            </div>
                        </div>

                        <table class="table table-striped table-hover table-bordered datatable shadow" id="tabelbulanan"
                            style="width: 100%">
                            <thead class="fw-bold">
                                <tr>
                                    {{-- <th class="text-center">id</th>
                                    <th class="text-center">No.</th> --}}
                                    <th id="th" class="text-center w-25">Nama</th>
                                    <th id="th" class="text-center">Umur</th>
                                    <th id="th" class="text-center">Jenis Kelamin
                                    </th>
                                    <th id="th" class="text-center w-25">Status</th>
                                    <th id="th" class="text-center w-25">Tanggal
                                        Priksa</th>
                                    <th id="th" class="text-center w-25">Posyandu</th>
                                    <th id="th" class="text-center">Opsi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>


                {{-- Script --}}
                <script>
                    // btn POSYANDU EXCEL
                    document.addEventListener('DOMContentLoaded', function() {
                        var dropdown = document.querySelector('.select_posyandu');
                        var button = document.getElementById('downloadButton');

                        dropdown.addEventListener('change', function() {
                            if (this.value !== 'null') {
                                button.removeAttribute('disabled');
                            } else {
                                button.setAttribute('disabled', 'disabled');
                            }
                        });
                    });


                    // Cara Ukur
                    const berdiriCheckbox = document.getElementById('berdiriCheckbox');
                    const telentangCheckbox = document.getElementById('telentangCheckbox');
                    const cUkurInput = document.getElementById('c_ukur');

                    berdiriCheckbox.addEventListener('change', function() {
                        if (berdiriCheckbox.checked) {
                            telentangCheckbox.checked = false;
                            cUkurInput.value = 'Berdiri';
                        } else {
                            cUkurInput.value = '';
                        }
                    });

                    telentangCheckbox.addEventListener('change', function() {
                        if (telentangCheckbox.checked) {
                            berdiriCheckbox.checked = false;
                            cUkurInput.value = 'Telentang';
                        } else {
                            cUkurInput.value = '';
                        }
                    });


                    // Mendapatkan elemen select dengan class 'form-select' dan id 'danaks_id'
                    let select = document.getElementById('danaks_id');

                    // Mendapatkan elemen input dengan id 'umur_tahun'
                    let umurInputt = document.getElementById('umur_tahun');
                    let umurInputb = document.getElementById('umur_bulan');
                    let umurInputa = document.getElementById('umur_periksa');
                    let posyanduInput = document.getElementById('nama_posyandu');

                    // Menambahkan event listener untuk mengubah nilai input saat opsi dipilih
                    select.addEventListener('change', function() {
                        // Mendapatkan umur dari data-umur pada opsi yang dipilih
                        let selectedOption = select.options[select.selectedIndex];
                        let umurt = selectedOption.getAttribute('data-umur');
                        let umurb = selectedOption.getAttribute('data-umur2');
                        let umura = selectedOption.getAttribute('data-umur3');
                        let posyandu = selectedOption.getAttribute('data-nama_posyandu');

                        // Memasukkan nilai umur ke dalam input 'umur_tahun'
                        umurInputt.value = umurt;
                        umurInputb.value = umurb;
                        umurInputa.value = umura;
                        posyanduInput.value = posyandu;
                    });


                    // Stautus BMI RUMUS BESAR
                    // Ambil elemen input bb_anak, tb_anak, dan st_anak
                    let bb_anakInput = document.getElementById('bb_anak');
                    let tb_anakInput = document.getElementById('tb_anak');
                    let st_anakInput = document.getElementById('st_anak');
                    let danaksId = document.getElementById('danaks_id');

                    // Tambahkan event listener untuk perubahan dropdown
                    danaksId.addEventListener('change', updateStatusAnak);
                    bb_anakInput.addEventListener('input', updateStatusAnak);
                    tb_anakInput.addEventListener('input', updateStatusAnak);

                    function updateStatusAnak() {
                        let selectedOption = danaksId.options[danaksId.selectedIndex];
                        let jkValue = selectedOption.getAttribute('data-jk');

                        let bb_anakValue = parseFloat(bb_anakInput.value);
                        let tb_anakValue = parseFloat(tb_anakInput.value);

                        if (!isNaN(bb_anakValue) && !isNaN(tb_anakValue)) {
                            let st_anakValue = bb_anakValue + tb_anakValue;

                            if (jkValue === 'L') {
                                if (st_anakValue <= 10) {
                                    st_anakInput.value = "Gizi Buruk";
                                } else {
                                    st_anakInput.value = "Gizi Baik";
                                }
                            } else if (jkValue === 'P') {
                                if (st_anakValue <= 10) {
                                    st_anakInput.value = "Gizi Baik";
                                } else {
                                    st_anakInput.value = "Gizi Buruk";
                                }
                            }
                        } else {
                            st_anakInput.value = '- Inputan Tidak Valid';
                        }
                    }

                    // Select
                    function selectAllText(input) {
                        input.select();
                    };

                    // Tabel Antrian
                    function tampilkanTabel(button) {
                        var badges = document.querySelectorAll('.badge.ku');

                        // Remove 'active' class from all badges
                        badges.forEach(function(badge) {
                            badge.classList.remove('active');
                        });

                        // Add 'active' class to the clicked badge
                        button.classList.add('active');

                        // Display the table
                        var tabel = document.getElementById("tabel_antrian");
                        tabel.style.display = "table";
                    }

                    // Search
                    document.addEventListener("DOMContentLoaded", function() {
                        const searchInput = document.getElementById("searchInput");
                        const danaksSelect = document.getElementById("danaks_id");

                        // Simpan opsi "Silahkan Pilih Nama" ke dalam variabel
                        const placeholderOption = danaksSelect.querySelector('option[value="null"]');

                        // Membuat daftar semua opsi (kecuali opsi "Silahkan Pilih Nama")
                        const options = Array.from(danaksSelect.options).filter(option => option.value !== "null");

                        // Menambahkan event listener untuk input pencarian
                        searchInput.addEventListener("input", function() {
                            const searchText = searchInput.value.toLowerCase();
                            const filteredOptions = options.filter(option => option.textContent.toLowerCase().includes(
                                searchText));

                            // Mengosongkan dropdown
                            danaksSelect.innerHTML = '';

                            // Tambahkan kembali opsi "Silahkan Pilih Nama"
                            danaksSelect.appendChild(placeholderOption);

                            // Menampilkan opsi yang sesuai
                            filteredOptions.forEach(option => {
                                danaksSelect.appendChild(option.cloneNode(true));
                            });
                        });
                    });

                    // Reset
                    document.addEventListener("DOMContentLoaded", function() {
                        // Temukan elemen tombol reset
                        let resetButton = document.getElementById("reset");

                        // Temukan semua elemen input dalam formulir yang ingin di-reset, kecuali untuk input pencarian
                        let inputElements = document.querySelectorAll('input[type="text"], input[type="number"]');
                        // Kecualikan input pencarian dari daftar elemen input
                        let searchInput = document.getElementById("searchInput");

                        // Temukan elemen select yang ingin di-reset
                        let danaksSelect = document.getElementById("danaks_id");

                        // Temukan semua elemen radio
                        let radioElements = document.querySelectorAll('input[type="radio"]');

                        // Temukan semua elemen checkbox
                        let checkboxElements = document.querySelectorAll('input[type="checkbox"]');

                        // Simpan indeks pilihan awal
                        let initialSelectedIndex = danaksSelect.selectedIndex;

                        // Tambahkan event listener untuk tombol reset
                        resetButton.addEventListener("click", function() {
                            // Loop melalui semua elemen input kecuali input pencarian dan reset nilainya
                            inputElements.forEach(function(input) {
                                if (input !== searchInput) {
                                    if (input.type === "text") {
                                        input.value = "- Silahkan Pilih Jenis Kelamin";
                                    } else if (input.type === "number") {
                                        input.value = 0;
                                    }
                                }
                            });

                            // Reset pilihan pada elemen select ke opsi pertama (indeks 0)
                            danaksSelect.selectedIndex = initialSelectedIndex;

                            // Uncheck semua radio buttons
                            radioElements.forEach(function(radio) {
                                radio.checked = false;
                            });

                            // Uncheck semua checkbox
                            checkboxElements.forEach(function(checkbox) {
                                checkbox.checked = false;
                            });
                        });
                    });
                </script>
            </div>
    </section>

    {{-- PESAN ERROR --}}
    @if (session('error'))
        <script>
            alert("{{ session('error') }}");
        </script>
    @endif
@endsection


@push('scripts')
    <script type="module">
        $(document).ready(function() {
            $.fn.DataTable.ext.pager.numbers_length = 5;
            var dataTable = new DataTable('#tabelbulanan', {
                serverSide: true,
                processing: true,
                ajax: "gettabelbulanan",
                pagingType: "simple_numbers",
                responsive: true,
                columns: [
                    // {
                    //     data: "id",
                    //     name: "id",
                    //     visible: false,
                    //     searchable: false,
                    // },
                    // {
                    //     data: "DT_RowIndex",
                    //     name: "DT_RowIndex",
                    //     orderable: false,
                    //     searchable: false,
                    //     visible: false,
                    //     width: "3%",
                    //     className: ' align-middle',
                    //     render: function(data, type, row, meta) {
                    //         return data + '.';
                    //     }

                    // },
                    {
                        data: "danaks.nama_anak",
                        name: "danaks.nama_anak",
                        className: 'align-middle',
                        // width: "25%",
                        orderable: false,

                    },
                    {
                        data: "umur_periksa",
                        name: "umur_periksa",
                        className: ' align-middle',
                        width: "10%",
                        searchable: false,
                        visible: false,
                        orderable: false,

                    },
                    {
                        data: "danaks.jk",
                        name: "danaks.jk",
                        className: 'align-middle',
                        // width: "15%",
                        searchable: false,
                        orderable: false,

                    },
                    {
                        data: "st_anak",
                        name: "st_anak",
                        className: ' align-middle',
                        // width: "15%",
                        render: function(data, type, row, meta) {
                            if (data === 'Gizi Baik') {
                                return '<span style="color: green; font-weight:bold ">' +
                                    data + '</span>';
                            } else if (data === 'Gizi Buruk') {
                                return '<span style="color: red; font-weight:bold  ">' +
                                    data + '</span>';
                            } else {
                                return data;
                            }
                        },
                        searchable: false,
                        orderable: false,

                    },
                    {
                        data: "created_at",
                        name: "created_at",
                        className: ' align-middle',
                        // width: "15%",
                        render: function(data) {
                            // Konversi data tanggal dari format default (biasanya ISO 8601) ke "DD-MM-YYYY"
                            if (data) {
                                var date = new Date(data);
                                var day = date.getDate();
                                var month = date.getMonth() +
                                    1; // Perlu ditambahkan 1 karena Januari dimulai dari 0
                                var year = date.getFullYear();
                                // Format tanggal dalam "DD-MM-YYYY"
                                return day.toString().padStart(2, '0') + '-' + month.toString()
                                    .padStart(2, '0') + '-' + year;
                            } else {
                                return '';
                            }
                        },
                    },
                    {
                        data: "nama_posyandu",
                        name: "nama_posyandu",
                        className: 'align-middle',
                        // width: "25%",
                        searchable: true,

                    },
                    {
                        data: "actions2",
                        name: "actions2",
                        orderable: false,
                        searchable: false,
                        className: 'align-middle',
                        width: "5%"

                    },
                ],
                order: [
                    [4, "desc"]
                ],
                lengthMenu: [
                    [25, 50, 100, -1],
                    [25, 50, 100, "All"],
                ],
            });



            // Tabel Antrian
            $(document).ready(function() {
                $('.badge.ku').on('click', function() {
                    var posyanduValue = $(this).text().trim();
                    $('#tabel_antrian_filter input[type="search"]').val(posyanduValue).trigger(
                        'input');
                    dataTable.search(posyanduValue).draw(); // Memfilter dan memperbarui DataTable
                });
                var dataTable = new DataTable('#tabel_antrian', {
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: "gettabelantrian1",
                    pagingType: 'simple',
                    columns: [{
                            data: "id",
                            name: "id",
                            visible: false
                        },
                        {
                            data: "DT_RowIndex",
                            name: "DT_RowIndex",
                            orderable: false,
                            searchable: false,
                            className: 'text-center align-middle',
                            render: function(data, type, row, meta) {
                                return data + '.';
                            }
                        },
                        {
                            data: "n_antrian",
                            name: "n_antrian",
                            className: 'align-middle',
                            searchable: false,
                            orderable: false,
                        },
                        {
                            data: "t_posyandu",
                            name: "t_posyandu",
                            className: 'align-middle',

                        },
                        {
                            data: "actions",
                            name: "actions",
                            orderable: false,
                            searchable: false,
                            className: 'align-middle',
                            width: "5%"

                        },
                    ],
                    order: [
                        [3, "desc"]
                    ],
                    lengthMenu: [
                        [6],
                        [6],
                    ],

                    searching: true,
                    search: {
                        smart: false,
                        regex: true
                    },
                    language: {
                        search: "", // Mengganti teks "Search" menjadi "Cari"
                    },
                });
                $('#tabel_antrian_filter input[type="search"]').prop('disabled', true);
            });
        });
    </script>
@endpush
