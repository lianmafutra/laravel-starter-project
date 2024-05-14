@extends('admin.layouts.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

    <link rel="stylesheet" href="{{ asset('plugins/flatpicker/flatpickr.min.css') }}">

    <link rel="stylesheet" href="{{ asset('template/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('template/admin/plugins/summernote/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('plugins/filepond/filepond.css') }}" />
    <link rel="stylesheet" href="{{ asset('plugins/filepond/filepond-plugin-image-preview.css') }}" />
    <link rel="stylesheet" href="{{ asset('plugins/filepond/filepond-plugin-get-file.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/filepond/filepond-plugin-image-overlay.css') }}">

    <link rel="stylesheet" href="{{ asset('plugins/magnific/magnific-popup.min.css') }}" />

    <link rel="stylesheet" href="{{ asset('plugins/filepond/filepond-plugin-file-poster.css') }}" />

    <style>
        .filepond--list-scroller {
            cursor: default;
        }

        .filepond--root {
            height: auto;
        }

        @media (min-width: 576px) {
            #file_cover_multi .filepond--item {
                width: calc(32% - 0.5em);
            }
        }
    </style>
@endpush
@section('header')
  
<x-header title="Modul Upload" back-button="true"></x-header>
@endsection
@section('content')
    <div class="col-lg-8 col-sm-12">
        <form id="form_sample" action="{{ route('sample-crud.store') }}" method="post">
            @csrf
            <div class="card">
               
                <div class="card-body">
                    <x-input label="Judul " id="title"
                        placeholder="Judul File Modul" />
                    <x-textarea id="desc" label="Short Description" placeholder="Description" />
                    <x-select2 id="jenis_paket" label="Jenis Paket" placeholder="Select Jenis Paket">
                        <option value="Free">Free</option>
                        <option value="Premium">Premium</option>
                    </x-select2>
                    <x-filepond id="file_cover" label='File Cover' info='( Format File JPG/PNG , Maks 5 MB)'
                    accept="image/jpeg, image/png" />

                    <x-filepond id="file_modul" name="file_modul" label='File Modul'
                        info='( Format File : Dokumen, Video, Note )' multiple />
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
    <script src="{{ asset('template/admin/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('template/admin/plugins/summernote/summernote-bs4.min.js') }}"></script>

    {{-- currency format input --}}
    <script src="{{ asset('plugins/autoNumeric.min.js') }}"></script>

    {{-- flatcpiker format date input --}}
    <script src="{{ asset('plugins/flatpicker/flatpickr.min.js') }}"></script>
    <script src="{{ asset('plugins/flatpicker/id.min.js') }}"></script>

    {{-- filepond --}}
    <script src="{{ asset('plugins/filepond/filepond-plugin-file-poster.js') }}"></script>
    <script src="{{ asset('plugins/filepond/filepond.js') }}"></script>
    <script src="{{ asset('plugins/filepond/filepond-plugin-file-metadata.js') }}"></script>
    <script src="{{ asset('plugins/filepond/filepond-plugin-file-encode.js') }}"></script>
    <script src="{{ asset('plugins/filepond/filepond-plugin-file-validate-type.js') }}"></script>
    <script src="{{ asset('plugins/filepond/filepond-plugin-file-validate-size.js') }} "></script>
    <script src="{{ asset('plugins/filepond/filepond-plugin-image-preview.js') }}"></script>
    <script src="{{ asset('plugins/filepond/filepond-get-files.js') }}"></script>
    <script src="{{ asset('plugins/filepond/filepond-plugin-image-overlay.js') }}"></script>
    <script src="{{ asset('plugins/magnific/jquery.magnific-popup.min.js') }}"></script>


    {{-- password toggle show/hide --}}
    <script src="{{ asset('plugins/toggle-password.js') }}"></script>

    {{-- masking input currency,date input --}}
    <script src="{{ asset('plugins/jquery.mask.min.js') }}"></script>
  

    <script>
        $(function() {

            $('.select2bs4').select2({
                theme: 'bootstrap4',
            })

            AutoNumeric.multiple('.rupiah', {
                digitGroupSeparator: '.',
                decimalPlaces: 0,
                minimumValue: 0,
                decimalCharacter: ',',
                formatOnPageLoad: true,
                allowDecimalPadding: false,
                alwaysAllowDecimalCharacter: false
            });


            flatpickr.setDefaults({
                dateFormat: "d/m/Y",
                locale: "id",
                disableMobile: "true",
            })

            const date_publisher = flatpickr("#date_publisher", {
                allowInput: true,

                defaultDate: ''
            });

            const start_date = flatpickr("#start_date", {
                allowInput: true,

                defaultDate: ''
            });

            const end_date = flatpickr("#end_date", {
                allowInput: true,

                defaultDate: ''
            });

            const time = flatpickr("#time", {
                enableTime: true,

                noCalendar: true,
                dateFormat: "H:i",
                time_24hr: true
            });


            const date_range = $("#date_range").flatpickr({
                allowInput: true,

                mode: "range",
                onChange: function(dates, dateStr, instance) {
                    if (dates.length == 2) {
                        let dateStart = instance.formatDate(dates[0], "Y-m-d");
                        let dateEnd = instance.formatDate(dates[1], "Y-m-d");
                    }
                }
            })

            $('#date_publisher').mask('00/00/0000');
            $('#contact').mask('0000-0000-000000');

            FilePond.registerPlugin(
                //  FilePondPluginGetFile,
                FilePondPluginFileEncode,
                FilePondPluginImagePreview,
                FilePondPluginFilePoster,

                FilePondPluginFileValidateType,
                FilePondPluginFileValidateSize)

    



            $('#form_sample').submit(function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: route('modul.store'),
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

            const file_modul = FilePond.create(document.querySelector('#file_modul'));
            file_modul.setOptions({
                server: {
                    url: "{{ config('filepond.server.url') }}",
                    headers: {
                        'X-CSRF-TOKEN': "{{ @csrf_token() }}",
                    }
                },
                allowFileTypeValidation: true,
                acceptedFileTypes: ['application/pdf'],
                labelFileTypeNotAllowed: 'File of invalid type',
                allowMultiple: true,
                allowReorder: true,
                beforeRemoveFile: (file) => {
                    return confirm("Are You Sure Delete This File ?");
                },
                
                onactivatefile: (file) => {
                    const reader = new FileReader();
                    reader.onload = (event) => {
                        const blob = new Blob([event.target.result], {
                            type: file.type
                        });
                         console.log('Blob:', blob);
                        const blobUrl = URL.createObjectURL(blob);
                    };
                    reader.readAsArrayBuffer(file.file);


                },
            });

            const file_cover = FilePond.create(document.querySelector('#file_cover'));
            file_cover.setOptions({
                server: {
                    url: "{{ config('filepond.server.url') }}",
                    headers: {
                        'X-CSRF-TOKEN': "{{ @csrf_token() }}",
                    }
                },
                allowImagePreview: true,
                allowFileTypeValidation: true,
                acceptedFileTypes: ['image/*'],
                labelFileTypeNotAllowed: 'File of invalid type',
                beforeRemoveFile: (file) => {
                    return confirm("Are You Sure Delete This File ?");
                },
    

                onactivatefile: (file) => {
                    const reader = new FileReader();
                    reader.onload = (event) => {
                        const blob = new Blob([event.target.result], {
                            type: file.type
                        });
                        //  console.log('Blob:', blob);
                        const blobUrl = URL.createObjectURL(blob);

                        _showImageFilepond2(blobUrl)
                    };
                    reader.readAsArrayBuffer(file.file);


                },

            })
         

        })
    </script>
@endpush
