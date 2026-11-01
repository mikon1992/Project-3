<?php

// -> app/Http/Requests/ActivityRequest.php   (dipakai untuk store dan update)

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ActivityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // akses dijaga middleware auth pada route
    }

    public function rules(): array
    {
        return [
            'title'         => ['required', 'string', 'max:255'],
            'description'   => ['nullable', 'string'],
            'activity_date' => ['required', 'date'],
            'category'      => ['required', 'string', Rule::in(['Workshop', 'Seminar', 'Meeting', 'Tugas', 'Presentasi'])],
            'status'        => ['required', 'string', Rule::in(['Planned', 'Ongoing', 'Done'])],
        ];
    }
}
