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
                    <x-select2 id="master_kursus_id" label="Master Kursus" placeholder="Pilih Kursus">
                        @foreach ($masterKursus as $item)
                            <option value="{{ $item->uuid }}">{{ $item->judul }}</option>
                        @endforeach
                    </x-select2>

                    <x-select2 id="master_paket_soal_id" label="Pilih Paket Soal" placeholder="Pilih Paket Soal">
                    </x-select2>

                    <x-tiny-editor id="text_soal" label="Text Soal" name="text_soal"></x-tiny-editor>
                    <x-tiny-editor id="penjelasan" label="Text Penjelasan" name="penjelasan"></x-tiny-editor>

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
    <script src="{{ asset('plugins/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
    <script src="{{ asset('js/tinyEditorConfig.js') }}" referrerpolicy="origin"></script>

    <script>
        $(function() {

            $('.select2bs4').select2({
                theme: 'bootstrap4',
                allowClear: true
            })

            $('#form_sample').submit(function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: route('master-soal.store'),
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    beforeSend: function() {
                        _showLoading()
                    },
                    success: (response) => {
                        if (response) {
                            _alertSuccess(response.message)
                        }
                    },
                    error: function(response) {
                        _showError(response)
                    }
                })
            })


        })


        $(function() {
            $('#master_kursus_id').on('change', function() {
                $('#master_paket_soal_id').empty().append('<option value=""</option>').trigger('change');
                $.ajax({
                    url: route('master-paket-soal.getByMasterKursus', $(this).val()),
                    type: 'GET',
                    data: {
                        uuid: $(this).val()
                    },
                    success: function(data) {

                        $('#master_paket_soal_id').find('option:not(:first-child)').remove();
                        $.each(data, function(key, value) {
                            $('#master_paket_soal_id').append('<option value="' + value
                                .uuid + '">' + value.judul + " - " + value
                                .deskripsi + '</option>');
                        })

                    }
                })
            })
        })

        $('#active_1').prop('checked', true);

        _tinyEditorConfig({
            height: 300,
            selector: 'text_soal'
        })

        _tinyEditorConfig({
            height: 300,
            selector: 'penjelasan'
        })
    </script>
@endpush
