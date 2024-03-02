<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
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
    public function rules(): array
    {
        if (request()->input('type') === 'register') {
            return [
                'name' => 'required|unique:users,name',
                'email' => 'email|required|unique:users,email',
                'password' => 'required|min:12'
            ];
        }
        return [];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama Harus Di Isi',
            'name.unique' => 'Nama Sudah Dipakai',
            'email.email' => 'Email Tidak Valid',
            'email.required' => 'Email Harus Di Isi',
            'email.unique' => 'Email Sudah Dipakai',
            'password.required' => 'Password Harus Di Isi',
            'password.min' => 'Panjang Password Minimal Harus 12 Karakter'
        ];
    }
}
