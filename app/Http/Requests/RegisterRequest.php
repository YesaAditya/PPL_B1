<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
{
    return [
        'nama' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'no_telepon' => 'required|string|max:13|regex:/^[0-9]+$/',
        'kota' => 'required|string|max:255',
        'kecamatan' => 'required|string|max:255',
        'desaKelurahan' => 'required|string|max:255',
        'alamat' => 'required|string|max:500',
    ];
}
}
