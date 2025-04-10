<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWeaponsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Atau tambahkan logika otorisasi jika diperlukan
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'loadCellID' => 'required|integer',
            'slaveNumber' => 'required|integer',
            'status' => 'required|integer',
            'weight' => 'required|numeric',
            'rackNumber' => 'required|string|max:255',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'loadCellID.required' => 'Kolom loadCellID wajib diisi.',
            'loadCellID.integer' => 'Kolom loadCellID harus berupa angka bulat.',
            'slaveNumber.required' => 'Kolom slaveNumber wajib diisi.',
            'slaveNumber.integer' => 'Kolom slaveNumber harus berupa angka bulat.',
            'status.required' => 'Kolom status wajib diisi.',
            'status.integer' => 'Kolom status harus berupa angka bulat.',
            'weight.required' => 'Kolom weight wajib diisi.',
            'weight.numeric' => 'Kolom weight harus berupa angka.',
            'rackNumber.required' => 'Kolom rackNumber wajib diisi.',
            'rackNumber.string' => 'Kolom rackNumber harus berupa teks.',
            'rackNumber.max' => 'Kolom rackNumber tidak boleh lebih dari 255 karakter.',
        ];
    }
}
