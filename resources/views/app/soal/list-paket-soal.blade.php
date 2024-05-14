@extends('admin.layouts.master')
@section('header')
    {{-- <x-header title="Pilih Paket Soal"></x-header> --}}
@endsection
@section('content')
    <div class="card-body">


        <section class="content">



            <div class="card-body pb-0">

                <div class="row">

                    @foreach ($masterPaketSoal as $item)
                        <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                            <div class="card bg-light d-flex flex-fill">
                                <div class="card-header text-muted border-bottom-0">
                                    {{-- Digital Strategist --}}
                                </div>
                                <div class="card-body pt-0">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card-header">

                                                <h2 class="lead"><b style="font-size: 20px">{{ $item->judul }} -
                                                        @if ($item->jenis_paket == 'Free')
                                                            <span
                                                                style="color: green; font-weight: bold">{{ $item->jenis_paket }}</span>
                                                        @else
                                                            <span
                                                                style="color: rgb(223, 132, 20); font-weight: bold">{{ $item->jenis_paket }}</span>
                                                        @endif
                                                    </b>
                                                </h2>
                                            </div>
                                            <ul class="ml-4 mb-0 mt-4 fa-ul text-muted">

                                                <li class="text-muted text-sm"><span class="fa-li"><i
                                                            class="far fa-folder"></i></span>{{ $item->deskripsi }}</li>
                                                <li class="text-muted text-sm"><span class="fa-li"><i
                                                            class="far fa-file-alt"></i></i></span> {{ $item->jumlah_soal }}
                                                </li>
                                            </ul>
                                        </div>

                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="text-right">
                                        <a href="#" class="btn btn-sm bg-teal">
                                            Histori <i class="fas fa-info"></i>
                                        </a>
                                        <a href="{{ route('kuis.user.kerjakan', $item->uuid) }}" class="btn btn-sm btn-primary">
                                            Kerjakan <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </section>
    </div>
@endsection
@push('js')
    <script>
        Swal.fire({
            title: '',
            text: "Untuk Mendapatkan Akses Semua Fitur Premium : Paket Soal, Modul, Bonus dll,  Silahkan Upgrade Ke Account Premium",
            icon: 'warning',
            confirmButtonColor: '#3085d6',
            allowOutsideClick: true,
            confirmButtonText: 'Upgrade Sekarang'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.replace(route('login'))
            }
        })
    </script>
@endpush
