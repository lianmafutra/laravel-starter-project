@extends('admin.layouts.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

    <link rel="stylesheet" href="{{ asset('template/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@endpush
@section('header')
    <x-header title="Create Master Paket Soal" back-button="true"></x-header>
@endsection
@section('content')
    <div class="col-lg-8 col-sm-12">
        <form id="form_sample" action="{{ route('master-paket-soal.store') }}" method="post">
            @csrf
            <div class="card">

                <div class="card-body">
                    <x-select2 id="master_kursus_id" label="Master Kursus" placeholder="Select Master Kursus">
                        @foreach ($masterKursus as $item)
                            <option value="{{ $item->id }}">{{ $item->judul }}</option>
                        @endforeach
                    </x-select2>
                    <x-input label="Judul " id="judul" placeholder="Judul Paket Soal" />
                    <x-textarea id="deskripsi" label="Short Description" placeholder="Description" />
                    <x-select2 id="jenis_paket" label="Jenis Paket" placeholder="Select Jenis Paket">
                        <option value="Free">Free</option>
                        <option value="Premium">Premium</option>
                    </x-select2>
                    <x-input-number id="durasi" label="Durasi ( Format Detik )" name="durasi" />
                    <x-check-box label="Status Active">
                        <x-checkbox.item id="active_1" name="active" text="Ya" type="radio" value="true"
                            color="primary">
                        </x-checkbox.item>
                        <x-checkbox.item id="active_2" name="active" text="Tidak" type="radio" value="false"
                            color="primary">
                        </x-checkbox.item>
                    </x-check-box>

                </div>
                <div class="card-footer">
                    <button type="submit" class="btn_submit btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('js')
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

    {{-- currency format input --}}
    <script src="{{ asset('plugins/autoNumeric.min.js') }}"></script>

    {{-- masking input currency,date input --}}
    <script src="{{ asset('plugins/jquery.mask.min.js') }}"></script>

    <script>
        $(function() {

            $('.select2bs4').select2({
                theme: 'bootstrap4',
            })

            $('#form_sample').submit(function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: route('master-paket-soal.store'),
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    beforeSend: function() {
                        _showLoading()
                    },
                    success: (response) => {
                        if (response) {
                            // this.reset()
                            _alertSuccess(response.message)
                        }
                    },
                    error: function(response) {
                        _showError(response)
                    }
                })
            })


        })
    </script>
@endpush
