<!-- resources/views/your-view.blade.php -->

@extends('layouts.appbalita')

@section('content')
    <div class="container mt-3 mb-4">
        <div class="d-flex justify-content-end mt-3 ms-3 mb-5">
            <a id="batal" href="/" class="btn btn-keluar">
                <div class="d-flex flex-row">
                    <i class="bi bi-box-arrow-left me-0 me-md-2"></i>
                    <span class="d-none d-md-block">Kembali</span>
                </div>
            </a>
        </div>

        <!-- Input Form for Validation -->
        <div class="row">
            <div class="col-md-6 col-12">
                <div class="mb-4">
                    <div class="card  px-md-5 py-md-5  px-3 py-4 shadow">
                        <div class="mb-5 text-center">
                            <img class="mx-auto d-block" src="{{ Vite::asset('resources/images/LogoMojokerto.png') }}"
                                alt="logo" style="width: 50%;">
                            <p class="fw-bold fs-2">
                                E-KMS Posyandu Japan
                            </p>
                        </div>
                        <form id="validationForm">
                            <div class="mb-3">
                                <label for="nik_anak" class="form-label fw-bold">NIK Anak</label>
                                <input type="number" class="form-control" id="nik_anak" name="nik_anak" required
                                    placeholder="Masukkan NIK Anak">
                            </div>
                            <div class="mb-0">
                                <label for="hp_ortu" class="form-label fw-bold">Nomor Hp</label>
                                <input type="number" class="form-control" id="hp_ortu" name="hp_ortu" required
                                    placeholder="Masukkan Nomor Hp">
                            </div>
                            <div class="form-text mb-3 " id="basic-addon4">Masukkan Nomor Hp yang sudah Terdaftar.</div>
                            <div class="d-flex flex-row justify-content-center">
                                <a href="/ekms" class="btn btn-keluar w-50 w-md-25 shadow me-2">
                                    <i class="bi bi-arrow-repeat"></i> Ulangi
                                </a>
                                <button type="submit" class="btn w-50 w-md-25 shadow me-2" id="btn-tambah">
                                    <i class="bi bi-search"></i> Cari
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <!-- Data Table -->
                <div class="d-flex flex-row justify-content-center align-items-center" id="dataTableContainer"
                    style="display: none;">
                    <div class="w-100">
                        <table class="table table-striped table-hover table-bordered datatable shadow" id="ekms"
                            style="width: 100%">
                            <thead class="fw-bold">
                                <tr>
                                    <th id="th" class="text-center">Nama</th>
                                    <th id="th" class="text-center">NIK</th>
                                    <th id="th" class="text-center">Posyandu</th>
                                    <th id="th" class="text-center">Opsi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@push('scripts')
    <script type="module">
        (function() {
            function hideNIK(nik) {
                var prefix = nik.substring(0, 4);
                var hiddenPart = nik.substring(4).replace(/./g, '*');
                return prefix + hiddenPart;
            }

            $('#validationForm').on('submit', function(e) {
                e.preventDefault();
                var nik_anak = $('#nik_anak').val();
                var hp_ortu = $('#hp_ortu').val();
                var $btnTambah = $('#btn-tambah');
                $btnTambah.prop('disabled', true);
                $.ajax({
                    url: '{{ route('validateAnak') }}',
                    method: 'POST',
                    data: {
                        nik_anak: nik_anak,
                        hp_ortu: hp_ortu,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.valid) {
                            $('#dataTableContainer').show();
                            loadDataTable(nik_anak);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Pencarian Tidak Ditemukan',
                                text: 'Periksa Kembali NIK dan Nomor Hp yang benar'
                            });
                            $btnTambah.prop('disabled', false);
                        }
                    }
                });
            });

            function loadDataTable(nik_anak) {
                var dataTable = new DataTable('#ekms', {
                    serverSide: true,
                    processing: true,
                    ajax: {
                        url: 'getekms',
                        data: {
                            nik_anak: nik_anak
                        }
                    },
                    pagingType: "simple",
                    responsive: true,
                    columns: [{
                            data: "danaks.nama_anak",
                            name: "danaks.nama_anak",
                            className: 'align-middle',
                            searchable: true,
                            orderable: true,
                        },
                        {
                            data: "danaks.nik_anak",
                            name: "danaks.nik_anak",
                            className: 'align-middle text-center',
                            searchable: true,
                            orderable: true,
                            render: function(data, type, row, meta) {
                                return hideNIK(data);
                            }
                        },
                        {
                            data: "nama_posyandu",
                            name: "nama_posyandu",
                            className: 'align-middle',
                            searchable: false,
                            orderable: true,
                        },
                        {
                            data: "actionsekms",
                            name: "actionsekms",
                            orderable: false,
                            searchable: false,
                            className: 'align-middle',
                            width: "5%"
                        },
                    ],
                    order: [
                        [0, "asc"]
                    ],
                    lengthMenu: [
                        [10],
                        [10]
                    ],
                    language: {
                        search: "Cari",
                    },
                    dom: 's'
                });
            }

        })();
    </script>
@endpush
