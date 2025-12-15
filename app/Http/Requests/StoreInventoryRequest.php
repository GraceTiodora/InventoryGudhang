<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInventoryRequest extends FormRequest
{
    /**
     * Tentukan apakah user diizinkan membuat request ini.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Dapatkan validasi rules yang berlaku untuk request.
     */
    public function rules(): array
    {
        return [
            'code' => 'required|string|max:50|unique:inventories,code',
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'quantity' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'supplier' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Custom error messages
     */
    public function messages(): array
    {
        return [
            'code.required' => 'Kode barang harus diisi',
            'code.unique' => 'Kode barang sudah terdaftar',
            'code.max' => 'Kode barang maksimal 50 karakter',
            'name.required' => 'Nama barang harus diisi',
            'name.max' => 'Nama barang maksimal 255 karakter',
            'category.required' => 'Kategori barang harus diisi',
            'category.max' => 'Kategori maksimal 100 karakter',
            'quantity.required' => 'Jumlah stok harus diisi',
            'quantity.integer' => 'Jumlah stok harus berupa angka bulat',
            'quantity.min' => 'Jumlah stok tidak boleh negatif',
            'unit.required' => 'Satuan barang harus diisi',
            'unit.max' => 'Satuan maksimal 50 karakter',
            'price.required' => 'Harga barang harus diisi',
            'price.numeric' => 'Harga harus berupa angka',
            'price.min' => 'Harga tidak boleh negatif',
            'supplier.max' => 'Nama supplier maksimal 255 karakter',
            'description.max' => 'Deskripsi maksimal 1000 karakter',
        ];
    }
}
