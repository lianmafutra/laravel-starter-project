<?php

namespace App\Http\Requests;

use App\Models\MasterPaketSoal;
use Illuminate\Foundation\Http\FormRequest;

class MasterSoalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
      return true;
    }

    protected function prepareForValidation(): void
    {
 
      if ($this->master_paket_soal_id != null) {
       
         $this->merge(
             [ 'master_paket_soal_id' => MasterPaketSoal::where('uuid', $this->master_paket_soal_id)->first()->id]
         );
     }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
      return [
         'text_soal' => 'required|min:5|max:1000|string',
         'penjelasan' => 'required|min:5|max:10000|string',
         'active' => 'required|string',
         'master_kursus_id' => 'required',
         'master_paket_soal_id' => 'required',
     ];
    }
}
