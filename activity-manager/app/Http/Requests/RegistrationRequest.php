<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegistrationRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'email' => strtolower(trim((string) $this->input('email'))),
            'participant_name' => trim((string) $this->input('participant_name')),
        ]);
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $activity = $this->route('activity');

        return [
            'participant_name' => ['required', 'string', 'max:120'],
            'email' => [
                'required',
                'email',
                'max:150',
                Rule::unique('registrations', 'email')
                    ->where(fn ($query) => $query->where('activity_id', $activity->id)),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'participant_name.required' => 'Nama peserta wajib diisi.',
            'email.required' => 'Email peserta wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email tersebut sudah terdaftar pada kegiatan ini.',
        ];
    }
}
