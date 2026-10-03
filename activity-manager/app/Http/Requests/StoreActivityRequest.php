<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
class StoreActivityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'code' => ['required', 'string', 'max:30', 'unique:activities,code'],
            'title' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'start_at' => ['required', 'date'],
            'end_at' => ['required', 'date', 'after_or_equal:start_at'],
            'location' => ['required', 'string', 'max:200'],
            'capacity' => ['required', 'integer', 'min:1', 'max:500'],
            'poster' => ['nullable', 'image', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.exists' => 'Kategori tidak ditemukan.',
            'code.unique' => 'Kode kegiatan sudah digunakan.',
            'end_at.after_or_equal' => 'Tanggal selesai tidak boleh lebih awal dari tanggal mulai.',
            'capacity.max' => 'Kapasitas maksimum untuk latihan adalah 500 peserta.',
            'poster.image' => 'Poster harus berupa file gambar yang valid.',
            'poster.max' => 'Ukuran poster maksimal 2 MB.',
        ];
    }
}