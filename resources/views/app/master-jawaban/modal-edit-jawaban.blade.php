<div class="modal fade" id="modal_create_edit_jawaban">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form autocomplete="off" id="form_modal_create_edit" method="POST">
                @csrf
                @method('POST')
                <div class="modal-body">
                    <section class="content">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                 <input autocomplete="off" hidden name="jawaban_id"></input>
                                 <input autocomplete="off" hidden name="master_soal_id"></input>
                                    <x-tiny-editor id="text_jawaban" label="Text Jawaban"
                                        name="text_jawaban"></x-tiny-editor>
                                        
                                    <x-check-box label="Nilai Jawaban">
                                        <x-checkbox.item id="jawaban_benar" name="nilai_jawaban" text="Benar"
                                            type="radio" value="benar" color="primary">
                                        </x-checkbox.item>
                                        <x-checkbox.item id="jawaban_salah" name="nilai_jawaban" text="Salah"
                                            type="radio" value="salah" color="primary">
                                        </x-checkbox.item>
                                    </x-check-box>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="modal-footer ">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button id="btn_action" type="submit" class="float-right btn btn-primary">Save</button>

                </div>
            </form>
        </div>
    </div>
</div>
