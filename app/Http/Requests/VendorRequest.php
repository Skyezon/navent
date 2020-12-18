<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VendorRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        //unique id di table user dihapus
        return [
            "name" => 'required|min:5',
            "password" => 'nullable|min:5',
            "phone" => 'numeric|min:10',
            "email" => 'required|unique:users,email',
            'image' => 'nullable|mimes:jpg,png,jpeg'
        ];
    }
}
