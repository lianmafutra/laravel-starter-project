<div style=" gap:5px;" class="d-flex justify-content-center">
   <a href="{{ route('master-kursus.edit', $data->uuid ?? "") }}"  data-toggle="tooltip" data-placement="bottom" title="Edit Data" class="btn btn-sm btn-primary btn_edit"
       data-id=""><i class="fas fa-pencil-alt"></i></a>
   <a href="#" data-action="{{ $data->judul }}" data-url="{{ route('master-kursus.destroy', $data->uuid ?? "") }}" data-toggle="tooltip" data-placement="bottom" title="Delete Data" class="btn btn-sm btn-danger btn_delete"><i class="fas fa-trash"></i></a>
</div>
