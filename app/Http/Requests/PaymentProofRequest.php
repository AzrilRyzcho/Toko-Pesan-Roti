<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentProofRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'payment_proof' => 'required|file|image|mimes:jpeg,png,jpg,webp|max:5120'
        ];
    }

    public function messages(): array
    {
        return [
            'payment_proof.required' => 'Harap pilih dan lampirkan foto bukti pembayaran terlebih dahulu.',
            'payment_proof.file' => 'File bukti pembayaran tidak valid.',
            'payment_proof.image' => 'File yang diunggah harus berupa gambar (foto).',
            'payment_proof.mimes' => 'Format gambar harus berupa JPG, JPEG, PNG, atau WEBP.',
            'payment_proof.max' => 'Ukuran gambar terlalu besar! Maksimal ukuran file adalah 5MB.',
            'payment_proof.uploaded' => 'Belum ada file yang dipilih atau ukuran file melampaui batas server. Silakan pilih kembali foto bukti transfer (maks 5MB).',
        ];
    }
}
