<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'nom' => 'required|min:3',
            'prenom' => 'required|min:3',
            'username' => 'required|string|min:4|unique:users',
            'email' => 'required|email|unique:users',
            'role' => 'required|string|in:user,admin,chefservice,magasinier',
            'password' => 'required|min:4',
        ];
    }
}