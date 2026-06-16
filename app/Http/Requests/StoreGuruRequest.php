<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreGuruRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'max:100', 'alpha_dash', 'unique:users,username'],
            'nip' => ['required', 'string', 'max:50', 'unique:gurus,nip'],
            'nama' => ['required', 'string', 'max:255'],
            'mata_pelajaran' => ['nullable', 'string', 'max:255'],
            'no_hp' => ['nullable', 'string', 'max:30'],
            'alamat' => ['nullable', 'string'],
            'status' => ['required', 'in:aktif,nonaktif'],
        ];
    }
}
