<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ModulRequest extends FormRequest
{
   public function authorize()
   {
       return true;
   }

   protected function prepareForValidation(): void
   {

       $this->merge([
      

       ]);
   }

   public function rules()
   {

       return [
           'title' => 'required|min:5|max:100|string',
           'desc' => 'required|min:5|max:100|string',
           'jenis_paket' => 'required|string',
           'file_modul' => 'required',
           'file_modul.*' => Rule::filepond([
               'file',
               'mimes:pdf',
               'max:10000',
           ]),
           'file_cover' => 'required', Rule::filepond([
               'file',
               'mimes:jpeg,jpg,png',
               'max:20000',
           ]),
          
       ];
   }
}
