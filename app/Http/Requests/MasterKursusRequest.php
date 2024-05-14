<?php

namespace App\Http\Requests;

use App\Utils\StringUtils;
use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

class MasterKursusRequest extends FormRequest
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
            'slug' => StringUtils::createSlug($this->judul),
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
         'judul' => 'required|min:5|max:100|string',
         'deskripsi' => 'required|min:5|max:100|string',
         'active' => 'required|string',
         'slug' => 'required|string',
         'file_cover' => 'required', Rule::filepond([
             'file',
             'mimes:jpeg,jpg,png',
             'max:20000',
         ]),
        
     ];
    }
}
