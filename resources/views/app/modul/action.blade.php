<div style=" gap:5px;" class="d-flex justify-content-center">
   <a href="#"data-url=" {{  $data->file_modul_r->file_url  }}" data-toggle="tooltip" data-placement="bottom" title="Preview" class="btn btn-sm btn-primary btn_preview"
      data-id=""><i class="fas fa-eye"></i> Preview </a>
   <a href="{{ route('modul.edit', $data->uuid ?? "") }}"  data-toggle="tooltip" data-placement="bottom" title="Edit Data" class="btn btn-sm btn-primary btn_edit"
       data-id=""><i class="fas fa-pencil-alt"></i></a>
   <a href="#" data-action="{{ $data->title }}" data-url="{{ route('modul.destroy', $data->uuid ?? "") }}" data-toggle="tooltip" data-placement="bottom" title="Delete Data" class="btn btn-sm btn-danger btn_delete"><i class="fas fa-trash"></i></a>
</div>
