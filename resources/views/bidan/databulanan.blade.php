    @extends('layouts.appnav')


    @section('content')
        @include('layouts.navbar')
        <section class="home-section mb-5">
            <div class="content">
                <div class="container mt-3 pt-3">
                    <div class="d-flex mb-4">
                        <div class="d-flex">
                            <span class="fw-bold h1">Data Bulanan</span>
                        </div>
                        <div class="ms-auto d-block d-md-none">
                            <a id="batal" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
            document.getElementById('logout-form').submit();"
                                class="btn btn-keluar">
                                <div class="d-flex flex-row align-items-center">
                                    <i class="bi bi-box-arrow-left me-0 me-md-2"></i>
                                    <span class="d-none d-md-block">Keluar</span>
                                </div>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                    <div class="row justify-content-center">

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
                        <div class="col-12 col-lg-6 mb-5 d-flex">
                            @include('actions.kalkulatorbidan')
                        </div>


                        {{-- TABEL BULANAN --}}
                        {{-- Triger Update data  --}}

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
                                        <th id="th" class="text-center w-25">Nama</th>
                                        <th id="th" class="text-center w-25">Umur</th>
                                        <th id="th" class="text-center w-25">Tanggal Priksa</th>
                                        <th id="th" class="text-center w-25">Posyandu</th>
                                        <th id="th" class="text-center">Opsi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        {{-- <div class="d-flex flex-row justify-content-center justify-content-md-end">
                            <a href="{{ route('destroy2') }}" class="btn btn-secondary mt-2 btn-chache"
                                data-href="{{ route('destroy2') }}" id="update-data">
                                <i class="bi bi-stars"></i>
                                Bersihkan Cache
                            </a>
                        </div> --}}
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
                    </script>
                </div>
        </section>
        <div class="d-block d-md-none">
            @include('layouts.bottombar2')
        </div>

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
                    columns: [{
                            data: "danaks.nama_anak",
                            name: "danaks.nama_anak",
                            className: 'align-middle',
                            // width: "25%",
                            orderable: false,

                        },
                        {
                            data: "umur_periksa",
                            name: "umur_periksa",
                            className: ' align-middle text-center',
                            width: "10%",
                            searchable: false,
                            orderable: false,

                        },
                        // {
                        //     data: "st_anak",
                        //     name: "st_anak",
                        //     className: ' align-middle text-center',
                        //     render: function(data, type, row, meta) {
                        //         if (data === 'Normal') {
                        //             return '<span style="color: mediumseagreen; font-weight:bold ">' +
                        //                 data + '</span>';
                        //         } else if (data === 'Pendek') {
                        //             return '<span style="color: red; font-weight:bold  ">' +
                        //                 data + '</span>';
                        //         } else if (data === 'Tinggi') {
                        //             return '<span style="color: Black; font-weight:bold  ">' +
                        //                 data + '</span>';
                        //         } else {
                        //             return data;
                        //         }
                        //     },
                        //     searchable: false,
                        //     orderable: false,

                        // },
                        // {
                        //     data: "gz_anak",
                        //     name: "gz_anak",
                        //     className: ' align-middle text-center',
                        //     render: function(data, type, row, meta) {
                        //         if (data === 'Normal') {
                        //             return '<span style="color: mediumseagreen; font-weight:bold ">' +
                        //                 data + '</span>';
                        //         } else if (data === 'Gizi Buruk') {
                        //             return '<span style="color: red; font-weight:bold  ">' +
                        //                 data + '</span>';
                        //         } else if (data === 'Gizi Kurang') {
                        //             return '<span style="color: darkorange; font-weight:bold  ">' +
                        //                 data + '</span>';
                        //         } else if (data === 'Kelebihan Berat Badan') {
                        //             return '<span style="color: DarkBlue; font-weight:bold  ">' +
                        //                 data + '</span>';
                        //         } else if (data === 'Obesitas') {
                        //             return '<span style="color: Black; font-weight:bold  ">' +
                        //                 data + '</span>';
                        //         } else {
                        //             return data;
                        //         }
                        //     },
                        //     searchable: false,
                        //     orderable: false,

                        // },
                        {
                            data: "created_at",
                            name: "created_at",
                            className: ' align-middle text-center',
                            // width: "15%",
                            render: function(data) {
                                // Array nama-nama bulan
                                var months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni",
                                    "Juli", "Agustus", "September", "Oktober", "November",
                                    "Desember"
                                ];

                                // Konversi data tanggal dari format default (biasanya ISO 8601) ke "DD-MMMM-YYYY"
                                if (data) {
                                    var date = new Date(data);
                                    var day = date.getDate();
                                    var month = date.getMonth(); // Mengambil bulan dari 0 sampai 11
                                    var year = date.getFullYear();
                                    // Format tanggal dalam "DD-MMMM-YYYY"
                                    return day.toString().padStart(2, '0') + '-' + months[month] + '-' +
                                        year;
                                } else {
                                    return '';
                                }
                            },
                        },
                        {
                            data: "nama_posyandu",
                            name: "nama_posyandu",
                            className: 'align-middle text-center',
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
                    language: {
                        search: "Cari", // Mengganti teks "Search" menjadi "Cari"
                    },
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

                $(".datatable").on("click", ".btn-delete", function(e) {
                    e.preventDefault();

                    var form = $(this).closest("form");

                    Swal.fire({
                        title: "Apakah Anda Yakin Menghapus Data " + "?",
                        text: "Anda tidak akan dapat mengembalikannya!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "bg-primary",
                        confirmButtonText: "Ya, hapus!",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        </script>
    @endpush
