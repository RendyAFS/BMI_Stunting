@extends('layouts.appnav')

@section('content')
    @include('layouts.navbar')
    <section class="home-section">
        <div class="content">
            <div class="container mt-3 pt-3">
                <div class="row ">
                    <h1 class="fw-bold h mb-4">Dashboard </h1>

                    {{-- Total Anak --}}
                    <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6 col-12 mb-3">
                        <div class="card shadow rounded-2" id="card-dash"
                            style="width: 18rem; max-width:18rem; height: 15rem; max-height:15rem;">
                            <h5 class="card-header fw-bold"> <i class='bx bx-user'></i> Total Anak</h5>
                            <div class="card-body rounded-bottom-2" id="card-body-dash">
                                <h6 class="card-title">Pada Posyandu Kelurahan Japan</h6>
                                <div class="d-flex">
                                    <h1 class="me-2 fw-bold">{{ $danaks->count() }}</h1>
                                    <p class="fw-bold">
                                        Laki-laki: {{ $danaks->where('jk', 'L')->count() }} <br>
                                        Perempuan: {{ $danaks->where('jk', 'P')->count() }}
                                    </p>
                                </div>
                                <a href="{{ route('danaks.index') }}" class="btn btn-light fw-bold"
                                    id="btn-detail-dashboard">
                                    <i class="bi bi-info-circle me-1"></i> Detail
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Total Posyandu --}}
                    <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6 col-12 mb-3">
                        <div class="card shadow rounded-2" id="card-dash"
                            style="width: 18rem; max-width:18rem; height: 15rem; max-height:15rem;">
                            <h5 class="card-header fw-bold"><i class='bx bx-building-house'></i> Total Posyandu</h5>
                            <div class="card-body rounded-bottom-2" id="card-body-dash">
                                <h6 class="card-title">Pada Posyandu Kelurahan Japan</h6>
                                <div class="d-flex">
                                    <h1 class="fw-bold me-2">{{ $dposyandus->count() }}</h1>
                                    <p class="mt-2 fw-bold">
                                        Posyandu
                                    </p>
                                </div>
                                <a href="{{ route('dposyandus.index') }}" class="btn btn-light fw-bold"
                                    id="btn-detail-dashboard">
                                    <i class="bi bi-info-circle me-1"></i> Detail
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6 col-12 mb-3">
                        <div class="card shadow rounded-2" id="card-dash"
                            style="width: 18rem; max-width:18rem; height: 15rem; max-height:15rem;">
                            <h5 class="card-header fw-bold"><i class='bx bx-table'></i> Total Pendataan</h5>
                            <div class="card-body rounded-bottom-2" id="card-body-dash">
                                <h6 class="card-title">Pada Posyandu Kelurahan Japan</h6>
                                <div class="d-flex">
                                    <h1 class="me-2 fw-bold">{{ $dbulans->count() }}</h1>
                                    <p class="fw-bold">
                                        Gizi Baik: {{ $dbulans->where('st_anak', 'Gizi Baik')->count() }} <br>
                                        Gizi Buruk: {{ $dbulans->where('st_anak', 'Gizi Buruk')->count() }}
                                    </p>
                                </div>
                                <a href="{{ route('dbulanans.index') }}" class="btn btn-light fw-bold"
                                    id="btn-detail-dashboard">
                                    <i class="bi bi-info-circle me-1"></i> Detail
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6 col-12 mb-3">
                        <div class="card shadow rounded-2" id="card-dash"
                            style="width: 18rem; max-width:18rem; height: 15rem; max-height:15rem;">
                            <h5 class="card-header fw-bold"><i class='bx bx-walk' ></i>Total Antrian</h5>
                            <div class="card-body rounded-bottom-2" id="card-body-dash">
                                <h6 class="card-title">Pada Posyandu Kelurahan Japan</h6>
                                <div class="d-flex">
                                    <h1 class="me-2 fw-bold">{{ $dantrians->count() }}</h1>
                                </div>
                                <a href="{{ route('dbulanans.index') }}" class="btn btn-light fw-bold"
                                    id="btn-detail-dashboard">
                                    <i class="bi bi-info-circle me-1"></i> Detail
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-4 mt-4">
                        {!! $chart->container() !!}
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    <script src="{{ $chart->cdn() }}"></script>
    {{ $chart->script() }}

    {{-- PESAN ERROR --}}
    @if (session('error'))
        <script>
            alert("{{ session('error') }}");
        </script>
    @endif
@endsection
