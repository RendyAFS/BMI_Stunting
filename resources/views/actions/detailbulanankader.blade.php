@extends('layouts.appnav')

@section('content')
    <div class="loading-overlay">
        <div class="spinner-container">
            <div class="spinner-border text-success" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <label>Loading</label>
        </div>
    </div>
    {{-- @include('layouts.navbar') --}}
    <section class="home-section mb-5">
        <div class="mt-2 p-4">
            <div class="d-flex justify-content-start">
                <a class="btn d-flex me-sm-3 me-2 mb-3 mb-md-0" id="btn-tambah" href="javascript:void(0);"
                    onclick="history.back();">
                    <i class="bi bi-chevron-left me-2"></i>
                    Kembali
                </a>
            </div>
            @if (count($dbulanans) > 0)
                <button id="printButton" class="d-none">Cetak Halaman</button>
                <p class="text-center fs-3 fw-bold mb-3">
                    Data Bulanan - {{ $dbulanans[0]->danaks->nama_anak }}
                </p>
            @endif
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header fw-bold">
                        <button class="accordion-button " type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            <label for="" class="fw-bold">
                                1. Kurva Berat Badan Menurut Panjang/Tinggi Badan
                            </label>
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                        <div class="p-4 pe-none">
                            {!! $chart3->container() !!}
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header fw-bold">
                        <button class="accordion-button  collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            <label for="" class="fw-bold">
                                2. Kurva Panjang/Tinggi Badan Menurut Umur (Bulan)
                            </label>
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                        <div class="p-4 pe-none">
                            {!! $chart2->container() !!}
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header fw-bold">
                        <button class="accordion-button  collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            <label for="" class="fw-bold">
                                3. Kurva Berat Badan Menurut Umur (Bulan)
                            </label>
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                        <div class="p-4 pe-none">
                            {!! $chart->container() !!}
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header fw-bold">
                        <button class="accordion-button  collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            <label for="" class="fw-bold">
                                4. Kurva Linkar Kepala Menurut Umur (Bulan)
                            </label>
                        </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                        <div class="p-4 pe-none">
                            {!! $chart4->container() !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row p-lg-4 p-0">
                <div class="col-12 mt-4 mb-5 table-container">
                    <!-- Tambahkan elemen pembatas untuk memulai halaman baru -->
                    <div class="page-break"></div>

                    <table class="table table-striped table-hover table-bordered datatable shadow" id="example"
                        style="width: 100%">
                        <thead>
                            <tr>
                                <th id="th" class="text-center align-middle w-25">Nama</th>
                                <th id="th" class="text-center align-middle w-25">Umur Periksa</th>
                                <th id="th" class="text-center align-middle">Berat Badan</th>
                                <th id="th" class="text-center align-middle">Tinggi Badan</th>
                                <th id="th" class="text-center align-middle">Lingkar Lengan</th>
                                <th id="th" class="text-center align-middle">Lingkar Kepala</th>
                                <th id="th" class="text-center align-middle w-25">Status</th>
                                <th id="th" class="text-center align-middle w-25">Gizi</th>
                                <th id="th" class="text-center align-middle w-25">Tanggal Periksa</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            @foreach ($dbulanans->sortByDesc('created_at') as $data)
                                <tr>
                                    <td class="text-center">{{ $data->danaks->nama_anak }}</td>
                                    <td class="text-center">
                                        {{ $data->umur_tahun }} Tahun
                                        {{ $data->umur_bulan }} Bulan
                                    </td>
                                    <td class="text-center">{{ $data->bb_anak }} kg</td>
                                    <td class="text-center">{{ $data->tb_anak }} cm</td>
                                    <td class="text-center">{{ $data->ll_anak }} cm</td>
                                    <td class="text-center">{{ $data->lk_anak }} cm</td>
                                    <td class="text-center fw-bold"
                                        style="color: {{ $data->st_anak === 'Normal' ? 'mediumseagreen' : ($data->st_anak === 'Pendek' ? 'red' : ($data->st_anak === 'Tinggi' ? 'darkblue' : 'black')) }}">
                                        {{ $data->st_anak }}
                                    </td>
                                    <td class="text-center fw-bold"
                                        style="color: {{ $data->gz_anak === 'Normal' ? 'mediumseagreen' : ($data->gz_anak === 'Gizi Buruk' ? 'red' : ($data->gz_anak === 'Gizi Kurang' ? 'darkorange' : ($data->gz_anak === 'Kelebihan Berat Badan' ? 'darkblue' : 'black'))) }}">
                                        {{ $data->gz_anak }}
                                    </td>
                                    <td class="text-center">{{ $data->created_at->format('Y-m-d') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </section>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Menampilkan overlay saat halaman dimuat
            document.querySelector('.loading-overlay').style.display = 'flex';

            // Sembunyikan overlay setelah 2 detik setelah semua konten dimuat
            window.addEventListener('load', function() {
                setTimeout(function() {
                    document.querySelector('.loading-overlay').style.display = 'none';
                }, 2500); // 2 detik (dalam milidetik)
            });
        });
    </script>
    {{-- </section> --}}

    <script src="{{ $chart->cdn() }}"></script>
    {{ $chart->script() }}
    <script src="{{ $chart2->cdn() }}"></script>
    {{ $chart2->script() }}
    <script src="{{ $chart3->cdn() }}"></script>
    {{ $chart3->script() }}
    <script src="{{ $chart4->cdn() }}"></script>
    {{ $chart4->script() }}


    <script>
        // Fungsi ini dipanggil setelah delay 1.5 detik
        new DataTable('#example', {
            responsive: true,
            lengthChange: false, // Menghilangkan opsi page length
            paging: false, // Menghilangkan paging (halaman)
            searching: false,
            pageLength: -1 // Menghilangkan kotak pencarian
        });
    </script>
@endsection
