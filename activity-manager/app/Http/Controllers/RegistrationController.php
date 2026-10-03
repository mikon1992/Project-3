<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Models\Activity;
use App\Services\RegistrationService;
use Illuminate\Http\RedirectResponse;

class RegistrationController extends Controller
{
    public function __construct(private RegistrationService $registrationService)
    {
    }

    public function store(RegistrationRequest $request, Activity $activity): RedirectResponse
    {
        $this->registrationService->register($activity, $request->validated());

        return back()->with('success', 'Pendaftaran berhasil dicatat.');
    }
}
