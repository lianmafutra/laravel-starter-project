<div style=" gap:5px;" class="d-flex justify-content-center">
   <a href="#" data-url=" " data-toggle="tooltip" data-placement="bottom" title="Manage Soal" class="btn btn-sm btn-primary btn_manage"
      data-id=""><i class="fas fa-eye"></i> Manage Soal </a>
   <a href="{{ route('master-paket-soal.edit', $data->uuid ?? "") }}"  data-toggle="tooltip" data-placement="bottom" title="Edit Data" class="btn btn-sm btn-primary btn_edit"
       data-id=""><i class="fas fa-pencil-alt"></i></a>
   <a href="#" data-action="{{ $data->judul }}" data-url="{{ route('master-paket-soal.destroy', $data->uuid ?? "") }}" data-toggle="tooltip" data-placement="bottom" title="Delete Data" class="btn btn-sm btn-danger btn_delete"><i class="fas fa-trash"></i></a>
</div>
