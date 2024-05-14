<?php

namespace App\Http\Requests;

use App\Models\MasterPaketSoal;
use App\Models\MasterSoal;
use Illuminate\Foundation\Http\FormRequest;

class MasterJawabanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }


    protected function prepareForValidation(): void
    {
 
      if ($this->master_soal_id != null) {
       
         $this->merge(
             [ 'master_soal_id' => MasterSoal::where('uuid', $this->master_soal_id)->first()->id]
         );
     }
    }
    

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
      return [
         'text_jawaban' => 'required|min:5',
         'nilai_jawaban' => 'required',
         'master_soal_id' => 'required',
     ];
       
    }
}
