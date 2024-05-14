<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MasterPaketSoalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
 
    
        return [
            'judul' => 'required|min:5|max:100|string',
            'deskripsi' => 'required|min:5|max:100|string',
            'jenis_paket' => 'required|string',
            'durasi' => 'required|integer',
            'active' => 'required|string',
            'master_kursus_id' => 'required|integer',
        ];
    }
}
