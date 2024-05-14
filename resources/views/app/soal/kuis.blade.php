@extends('admin.layouts.master')
@section('header')
    {{-- <x-header title="Pilih Paket Soal"></x-header> --}}
    <style>
        .loading-image {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 150px;
            height: 150px;
            z-index: 2;
        }

        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgb(255 255 255);
            z-index: 1;
        }

        .custom-radio-vertical {
            margin-bottom: 20px;
            /* Adjust the value as needed */
        }
    </style>
@endsection
@section('content')
    <div class="card-body">
        <div class="col-12">
            <div class="row">

                <div class="col-lg-8 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            {{ $paketSoal->judul }} , {{ $paketSoal->master_kursus->judul }}
                        </div>
                        <div class="card-body">
                            <div class="loading-overlay loading_soal"></div>
                            <img src="{{ asset('img/spinner2.gif') }}" class="loading-image loading_soal" alt="Loading..." />
                            <div class="d-flex flex-row bd-highlight mb-3">
                                <div style="font-size: 18px" class="pr-2 bd-highlight" id="nomor_urut"></div>
                                <div class="bd-highlight">
                                    <span style="font-size: 18px" id="text_soal"></span>
                                </div>


                            </div>

                            <div id="layout_jawaban">
                                {{-- <div class="form-group answer-choice" style="margin-top: 30px; ">
                        <div class="form-check">
                           <input class="form-check-input" type="radio" name="answer" id="answerA" value="A">
                           <label class="form-check-label" for="answerA">
                              Option A
                           </label>
                        </div>
                     </div> --}}
                            </div>



                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-center">
                                <!-- Next and Back buttons with icons -->
                                <button data-user-soal-id="" data-nomor-urut="" data-kuis-user-id="" id="btn_sebelumnya"
                                    type="button" class="m-1 btn btn-primary">
                                    <i class="fas fa-arrow-left mr-1"></i> Sebelumnya
                                </button>
                                <button data-jawaban-id="" data-nomor-urut="" data-kuis-user-id="" type="button"
                                    id="btn_selanjutnya" class="m-1 btn btn-primary">
                                    Selanjutnya <i class="fas fa-arrow-right ml-1"></i>
                                </button>
                                <button style="display: none" data-user-soal-id="" data-nomor-urut="" data-kuis-user-id=""
                                    id="btn_submit_akhir" type="button" class="m-1 btn btn-warning">
                                    <i class="fas fa-arrow-right mr-1"></i> Submit Akhir
                                </button>
                            </div>

                        </div>
                    </div>
                </div>



                <div class="col-lg-4 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex bd-highlight">
                                <div class="mr-auto  bd-highlight">
                                    <i class="far fa-clock"></i> <span id="durasi"></span>
                                </div>
                                <div class="bd-highlight">
                                    <img src="{{ asset('img/spinner2.gif') }}"
                                        class="loading-image2 loading_waktu loading_soal2" height="30px"
                                        alt="Loading..." />
                                    <span class="mt-3" id="sisa_waktu"
                                        style="color: green; font-weight: bold; font-size: 18px">
                                    </span>

                                </div>

                            </div>

                        </div>

                    </div>
                    <div class="card">
                        <div class="card-header">
                            Nomor Soal
                        </div>
                        <style>
                            .soal_number {
                                font-weight: bold;
                                color: white;
                                width: 35px;
                                height: 35px;
                                font-size: 14px;
                                display: flex;
                                justify-content: center;
                                align-items: center;
                                /* padding: 20px !important; */
                                background-color: #a0a0a0;
                                margin: 7px;
                                border-radius: 5px;
                            }
                        </style>
                        <div class="card-body">
                            <center>
                                <img src="{{ asset('img/spinner2.gif') }}"
                                    class="loading-image2 loading_nomor_soal  loading_soal2" height="60px"
                                    alt="Loading..." />

                            </center>
                            <div id="soal_number" class="d-flex flex-wrap align-content-center">

                                {{-- @foreach (range(1, 90) as $key => $item)
                     <div class="p-2 soal_number">{{ $key + 1 }}</div>
                     @endforeach --}}


                            </div>
                        </div>
                        <span class="border-bottom"></span>
                        <div class="pt-2 justify-content-center d-flex flex-row bd-highlight mb-3">
                            <div class="p-2 bd-highlight"><span style="font-size: 12px" class="badge badge-success">Soal
                                    Saat Ini</span></div>
                            <div class="p-2 bd-highlight"><span style="font-size: 12px" class="badge badge-danger">Belum
                                    Dijawab</span></div>
                            <div class="p-2 bd-highlight"><span style="font-size: 12px"
                                    class="p-1 badge badge-primary">Sudah
                                    Dijawab</span></div>

                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
@push('js')
    @include('app.soal.modal-submit-akhir')
    <script>
        generateKuisUSerforFirst()

        let totalSoal = 0;
        let nomorUrutSekarang = "";
        let kuis_id=null;

        function generateKuisUSerforFirst() {
            $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                data: {
                    "master_paket_soal_id": @json($paketSoal->uuid)
                },
                url: route('kuis.user.generate-soal', @json($paketSoal->uuid)),

                success: (response) => {
                    //   console.log(response)
                    if (response) {
                        nomorUrutSekarang = 1;
                        getKuisSoalAll(response.id)
                        tampilkanSoalSesuaiNomor(response.id, 1)
                    }
                },
                error: function(response) {
                    console.log(response)
                }
            })
        }

        function submitAkhirKuis() {
            $.ajax({
                type: "PUT",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: route('kuis.user.submit', kuis_id),
                data: "data",
                dataType: "dataType",
                success: function(response) {
                    console.log(response)
                }
            });
        }



        function getKuisSoalAll(kuisUserId) {
            $('#soal_number').empty()
            $.ajax({
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: route('kuis.user.soal.all', kuisUserId),

                success: (response) => {
                    // console.log(response)
                    if (response) {
                        console.log(response)
                        kuis_id = response.id
                        // 
                        const minutes = response.master_paket_soal.durasi / 60;
                        $('#durasi').text("Durasi " + minutes + " Menit");
                        const display = document.getElementById('sisa_waktu');
                        startTimer(response.waktu_sisa, display);

                        response.kuis_user_soal.forEach((element, index) => {
                            let color = "";

                            if (element.jawaban_dipilih == null) {
                                color = "#dc3545"
                            } else {
                                color = "#007bff"
                            }



                            // $('.soal_number').css('background-color', '#007bff');


                            //    var element = $('.soal_number[data-nomor-urut="' + response.nomor_urut + '"]');
                            // element.css('background-color', '#28a745');

                            $('#soal_number').append(
                                `<a href="#"><div style=" background-color: ${color}"  data-kuis-user-id="${element.kuis_user_id}" data-nomor-urut="${element.nomor_urut}"
                                  class="p-2 soal_number" >${element.nomor_urut}</div></a>`)


                        });



                        var element = $('.soal_number[data-nomor-urut="' + nomorUrutSekarang + '"]');
                        element.css('background-color', '#28a745');
                        // element.css({
                        //    //  'padding': '3px',
                        //     'border': 'background-color'
                        // });
                        totalSoal = response.kuis_user_soal.length;
                        $('.loading_nomor_soal').fadeOut()
                    }
                },
                error: function(response) {
                    // console.log(response)
                }
            })
        }

        $(document).on('click', '.soal_number', function() {
            var kuisUserId = $(this).data('kuis-user-id');
            var nomorUrut = $(this).data('nomor-urut');
            updateJawaban()
            tampilkanSoalSesuaiNomor(kuisUserId, nomorUrut)
            nomorUrutSekarang = nomorUrut
            getKuisSoalAll(kuisUserId)
        })

        $('#btn_selanjutnya').click(function(e) {
            e.preventDefault();
            var kuisUserId = $(this).data('kuis-user-id');
            var nomorUrut = $(this).data('nomor-urut');
            updateJawaban()
            tampilkanSoalSesuaiNomor(kuisUserId, nomorUrut)
            nomorUrutSekarang = nomorUrut
            getKuisSoalAll(kuisUserId)
        });

        $('#btn_sebelumnya').click(function(e) {
            e.preventDefault();
            var kuisUserId = $(this).data('kuis-user-id');
            var nomorUrut = $(this).data('nomor-urut');
            updateJawaban()
            tampilkanSoalSesuaiNomor(kuisUserId, nomorUrut)
            nomorUrutSekarang = nomorUrut
            getKuisSoalAll(kuisUserId)
        });

        $('#btn_submit_akhir').click(function(e) {
            e.preventDefault();
            $('#modal_submit_akhir').modal('show');

        });

        $('#btn_lanjutkan_submit_akhir').click(function(e) {
            e.preventDefault();
            submitAkhirKuis()
        });

        function startTimer(duration, display) {



            let timer = duration;

            const intervalId = setInterval(() => {
                const minutes = Math.floor(timer / 60);
                const seconds = timer % 60;

                // Menampilkan angka dengan dua digit
                const displayMinutes = String(minutes).padStart(2, '0');
                const displaySeconds = String(seconds).padStart(2, '0');

                // Menampilkan hitungan mundur
                display.textContent = `${displayMinutes}:${displaySeconds}`;

                // Mengurangi 1 detik dari hitungan mundur
                timer--;

                // Menghentikan hitungan mundur jika sudah mencapai 0
                if (timer < 0) {
                    clearInterval(intervalId);
                    display.textContent = '00:00';
                    Swal.fire({
                        title: '',
                        text: "Maaf, Waktu Sudah Berakhir, Kuis Akan Di Submit Otomatis Oleh Sistem",
                        icon: 'warning',
                        confirmButtonColor: '#3085d6',
                        allowOutsideClick: false,
                        confirmButtonText: 'Ok, Lanjutkan'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            //  window.location.replace(route('login'))
                        }
                    })
                }
            }, 1000);
            $('.loading_waktu').fadeOut()
        }




        function updateJawaban() {
            var answerInputs = document.getElementsByClassName("jawaban_list");
            var selectedValue = "";

            for (var i = 0; i < answerInputs.length; i++) {
                if (answerInputs[i].checked) {
                    selectedValue = answerInputs[i].value;
                    break;
                }
            }

            $.ajax({
                type: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: route('kuis.user.jawab', selectedValue),
                success: (response) => {
                    tampilkanSoalSesuaiNomor(kuisUserId, nomorUrut)
                },
                error: function(response) {
                    console.log(response)
                }
            })
        }


        function tampilkanSoalSesuaiNomor(kuisUserId, nomorUrut) {


            $('.loading_soal').show();
            $('#layout_jawaban').empty()
            $.ajax({
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                url: route('kuis.user.soal.single', [kuisUserId, nomorUrut]),
                success: (response) => {

                    response.kuis_jawaban.forEach(element => {
                        $('#layout_jawaban').append(
                            `<div class="custom-control custom-radio custom-radio-vertical">
                              <input  value="${element.id}" type="radio" id="${element.id}" name="customRadio" class="jawaban_list custom-control-input">
                              <label class="custom-control-label" for="${element.id}"> ${element.text_jawaban}</label>
                           </div>`
                        )

                        if (response.jawaban_dipilih != null) {
                            $('#' + parseInt(response.jawaban_dipilih.slice(1, -1))).prop('checked',
                                true);
                        }

                    })

                    //   console.log(response)
                    $('.loading_soal').hide();
                    if (response.nomor_urut == 1) {
                        $('#btn_sebelumnya').prop('disabled', true);
                        $('#btn_selanjutnya').prop('disabled', false);
                        $('#btn_submit_akhir').hide();
                    } else if (response.nomor_urut == totalSoal) {
                        $('#btn_selanjutnya').prop('disabled', true);
                        $('#btn_sebelumnya').prop('disabled', false);
                        $('#btn_submit_akhir').show();


                    } else {
                        $('#btn_sebelumnya').prop('disabled', false);
                        $('#btn_selanjutnya').prop('disabled', false);
                        $('#btn_submit_akhir').hide();
                    }

                    if (!$.isEmptyObject(response)) {

                        $('#nomor_urut').html(response.nomor_urut + ". ");
                        $('#text_soal').html(response.text_soal);

                        $('#btn_selanjutnya').data('kuis-user-id', response.kuis_user_id);
                        $('#btn_selanjutnya').data('nomor-urut', response.nomor_urut + 1);

                        $('#btn_sebelumnya').data('kuis-user-id', response.kuis_user_id);
                        $('#btn_sebelumnya').data('nomor-urut', response.nomor_urut - 1);

                        // $('.soal_number').css('background-color', '#007bff');



                    }
                },
                error: function(response) {
                    console.log(response)
                }


            })
        }
    </script>
@endpush
