@extends('admin.layouts.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
@endpush
@section('header')
    <x-header title="Edit Master Paket Soal" back-button="true"></x-header>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12 col-sm-12">
            <form id="form_sample">
                @csrf
                @method('PUT')
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
        <div class="col-lg-12 col-sm-12">
            <div class="card">
                <div class="card-header">

                    <div class="d-flex">
                        <div class="mr-auto p-2">
                            <h6 style="font-size: 18px" class="m-0 header-font"> Jawaban </h6>
                        </div>
                        <div class="p-2">

                        </div>
                        <div class="p-2">
                            <a href="#" class="btn btn-sm btn-primary" id="btn_create_jawaban">
                                <i class="fas fa-plus"></i> Add </a>
                        </div>
                    </div>


                </div>

                <div class="card-body">


                    <table id="datatable_jawaban" style="width:100%" class="display table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Text Jawaban</th>
                                <th>Nilai Jawaban</th>

                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>


                </div>

            </div>




        </div>
    </div>
@endsection

@push('js')
    @include('app.master-jawaban.modal-edit-jawaban')
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('plugins/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
    <script src="{{ asset('js/tinyEditorConfig.js') }}" referrerpolicy="origin"></script>
    <script src="{{ asset('template/admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

    <script>
        $(function() {


            let datatable = $("#datatable_jawaban").DataTable({
                serverSide: true,
                searching: false,
                processing: true,
                lengthChange: false,
                paginate: false,
                pageLength: false,
                info: false,
                aaSorting: [],
                order: [
                    //   [2, 'desc']
                ],

                scrollX: true,
                bAutoWidth: false,
                fixedColumns: true,
                ajax: {
                    url: route('master-jawaban.index'),
                    data: function(d) {
                        d.soal_uuid = @json($masterSoal->uuid);
                    }
                },
                columns: [{
                        data: "DT_RowIndex",
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'text_jawaban',
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: 'nilai_jawaban',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: "action",
                        orderable: false,
                        searchable: false,

                    }
                ],
            })

            $('#datatable_jawaban').on('click', '.btn_edit', function(e) {
                e.preventDefault();
                _clearInput()

                $('#modal_create_edit_jawaban').modal('show')
                $('.modal-title').text('Edit Jawaban')
                let url = $(this).attr('data-url');
                $.get(url, function(response) {
                    $('#modal_create_edit_jawaban input[name=master_soal_id]').val(
                        @json($masterSoal->uuid))
                    $('#modal_create_edit_jawaban input[name=jawaban_id]').val(response.data.id)
                    tinymce.get('text_jawaban').setContent(response.data.text_jawaban);
                    if (response.data.nilai_jawaban == "benar") {
                        $('#jawaban_benar').prop('checked', true);
                    } else {
                        $('#jawaban_salah').prop('checked', true);
                    }
                })
            })

            $('#btn_create_jawaban').click(function(e) {
                e.preventDefault();
                _clearInput()
                $('#modal_create_edit_jawaban').modal('show')
                $('.modal-title').text('Create Jawaban')
                $('#modal_create_edit_jawaban input[name=master_soal_id]').val(@json($masterSoal->uuid))
                $('#jawaban_salah').prop('checked', true);
            });

            $('#form_modal_create_edit').submit(function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: @json(route('master-jawaban.store')),
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    beforeSend: function() {
                        _showLoading()
                    },
                    success: (response) => {
                        if (response) {
                            this.reset()
                            $('#modal_create_edit_user').modal('hide')
                            datatable.ajax.reload()
                            _alertSuccess(response.message)
                        }
                    },
                    error: function(response) {
                        _showError(response)
                    }
                })
            })

            $('#datatable_jawaban').on('click', '.btn_delete', function(e) {
                e.preventDefault()
                Swal.fire({
                    title: 'Are you sure, you want to delete this data ?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6 ',
                    confirmButtonText: 'Yes, Delete'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                _method: 'DELETE'
                            },
                            url: $(this).attr('data-url'),
                            beforeSend: function() {
                                _showLoading()
                            },
                            success: (response) => {
                                datatable.ajax.reload()
                                _alertSuccess(response.message)
                            },
                            error: function(response) {
                                _showError(response)
                            }
                        })
                    }
                })
            })

            $('.select2bs4').select2({
                theme: 'bootstrap4',
                allowClear: true
            })

            $('#form_sample').submit(function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: route('master-soal.update', @json($masterSoal->uuid)),
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
                    $("#master_paket_soal_id").val(@json($masterSoal->master_paket_soal->uuid)).change()

                }
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

        _tinyEditorConfig({
            height: 300,
            selector: 'text_jawaban'
        })

        $('#text_soal').html(@json($masterSoal->text_soal))
        $('#penjelasan').html(@json($masterSoal->penjelasan))


        if (@json($masterSoal->active) == "true") {
            $('#active_1').prop('checked', true);
        } else {
            $('#active_2').prop('checked', true);
        }

        $("#master_kursus_id").val(@json($masterSoal->master_paket_soal->master_kursus->uuid)).change()
    </script>
@endpush
