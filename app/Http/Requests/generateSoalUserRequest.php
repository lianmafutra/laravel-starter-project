<?php

namespace App\Http\Requests;

use App\Models\MasterPaketSoal;
use Illuminate\Foundation\Http\FormRequest;

class generateSoalUserRequest extends FormRequest
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
         $this->merge([
             'user_id' => auth()->user()->id,
             'master_paket_soal_id' => MasterPaketSoal::where('uuid', $this->master_paket_soal_id)->first()->id,
            
         ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
      return [
         'user_id' => 'required',
         'master_paket_soal_id' => 'required',
      
     ];
    }
}
