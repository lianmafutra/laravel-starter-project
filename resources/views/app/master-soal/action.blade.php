<div style=" gap:5px;" class="d-flex justify-content-center">
    <a href="{{ route('master-soal.edit', $data->uuid ?? '') }}" data-toggle="tooltip" data-placement="bottom"
        title="Edit Data" class="btn btn-sm btn-primary btn_edit" data-id=""><i class="fas fa-pencil-alt"></i></a>
    <a href="#" data-action="{{ $data->text_soal }}"
        data-url="{{ route('master-soal.destroy', $data->uuid ?? '') }}" data-toggle="tooltip"
        data-placement="bottom" title="Delete Data" class="btn btn-sm btn-danger btn_delete"><i
            class="fas fa-trash"></i></a>
</div>
