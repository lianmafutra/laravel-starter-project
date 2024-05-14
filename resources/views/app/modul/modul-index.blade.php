@extends('admin.layouts.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    @include('partials.css-settings')
@endpush
@section('header')
    <x-header title="Modul Pembelajaran"></x-header>
@endsection
@section('content')
    <div class="col-12">
        <div class="card">
            <div style="box-shadow: none !important; margin-bottom:0 !important" class="card collapsed-card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm col-auto col-md-auto">
                            <a href="{{ route('modul.create') }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-plus"></i> Upload</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="border-top"></div>
            <div class="card-body table-responsive">
                <table id="datatable" style="width:100%" class="display table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            {{-- <th>Cover</th> --}}
                            <th>Judul</th>
                            {{-- <th>Deskripsi</th> --}}
                            <th>Jenis Paket</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('plugins/sweetalert2/sweetalert2-min.js') }}"></script>
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

    <script src="{{ asset('template/admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/datatableFunction.js') }}"></script>

    <script>
        $(function() {

            let datatable = $("#datatable").DataTable({
                serverSide: true,
                processing: true,
                lengthChange: true,
                paginate: false,
                pageLength: 50,
                aaSorting: [],
                order: [
                    [2, 'desc']
                ],

                scrollX: true,
                bAutoWidth: false,
                fixedColumns: true,
                ajax: route('modul.index'),
                columns: [{
                        data: "DT_RowIndex",
                        orderable: false,
                        searchable: false,
                    },
                    //   {
                    //       data: 'file_cover',
                    //       orderable: false,
                    //       searchable: true,
                    //   },
                    {
                        data: 'title',
                        orderable: true,
                        searchable: true,
                    },
                    //   {
                    //       data: 'desc',
                    //       orderable: true,
                    //       searchable: true,
                    //   },
                    {
                        data: 'jenis_paket',
                        orderable: true,
                        searchable: false,
                    },


                    {
                        data: "action",
                        orderable: false,
                        searchable: false,
                      
                    },
                ],
            })

            $('#datatable').on('click', '.btn_preview', function(e) {
                e.preventDefault()
                checkExtensionAndOpen($(this).attr('data-url'));
            })

            $('#datatable').on('click', '.btn_delete', function(e) {
                e.preventDefault()
                Swal.fire({
                    title: 'Are you sure, you want to delete this data Permission ?',
                    text: $(this).attr('data-action'),
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
                                _alertSuccess(response.message)
                                datatable.ajax.reload()
                            },
                            error: function(response) {
                                _showError(response)
                            }
                        })
                    }
                })
            })
        })

        function checkExtensionAndOpen(filePath) {
            // Extracting file extension
            const extension = filePath.split('.').pop().toLowerCase();

            // List of allowed extensions (PDF and image formats)
            const allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png', 'gif'];

            // Checking if the extension is allowed
            if (allowedExtensions.includes(extension)) {
                // Opening the file in a new tab
                window.open(filePath, '_blank');
            } else {
                console.log("File format not supported!");
                // You can handle unsupported file formats in your desired way here
            }
        }
    </script>
@endpush
