<?php

namespace App\Http\Requests;

use App\Rules\Phone;
use Illuminate\Foundation\Http\FormRequest;

class StoreUser extends FormRequest
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
        return [
            'name'  => 'required|string|max:100|min:5',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', new Phone(), 'unique:users'],
            'zip'  => 'nullable|regex:/^\d{5}$/',
            //all file types and max size 10000kb
            'file'  => 'nullable|file|max:10000',
            //only images
            'photo' => 'nullable|mimes:jpeg,jpg,png,gif|max:10000',
            'address'   => 'nullable|string|max:100',
        ];
    }
}
