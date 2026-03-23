<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    private const TYPES = ['radio_ad', 'tailoring', 'printing', 'carpentry', 'contact'];

    public function store(Request $request, string $formType): RedirectResponse
    {
        if (! in_array($formType, self::TYPES, true)) {
            abort(404);
        }

        $baseRules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => $formType === 'tailoring'
                ? ['required', 'string', 'max:50']
                : ['nullable', 'string', 'max:50'],
            'message' => ['required', 'string', 'max:10000'],
        ];

        $extraRules = match ($formType) {
            'radio_ad' => [
                'business_name' => ['nullable', 'string', 'max:255'],
                'preferred_schedule' => ['nullable', 'string', 'max:500'],
                'campaign_duration' => ['nullable', 'string', 'max:255'],
            ],
            'tailoring' => [
                'garment_type' => ['nullable', 'string', 'max:500'],
                'deadline' => ['nullable', 'string', 'max:255'],
                'measurements_note' => ['nullable', 'string', 'max:2000'],
            ],
            'printing' => [
                'project_type' => ['nullable', 'string', 'max:255'],
                'quantity' => ['nullable', 'string', 'max:255'],
                'delivery_date' => ['nullable', 'string', 'max:255'],
            ],
            'carpentry' => [
                'project_scope' => ['nullable', 'string', 'max:2000'],
                'site_location' => ['nullable', 'string', 'max:500'],
                'budget_range' => ['nullable', 'string', 'max:255'],
            ],
            'contact' => [
                'subject' => ['nullable', 'string', 'max:255'],
                'inquiry_topic' => ['nullable', 'string', 'max:255'],
            ],
        };

        $validated = $request->validate(array_merge($baseRules, $extraRules));

        $message = $validated['message'];
        $metadataKeys = array_keys($extraRules);
        $metadata = array_filter(
            $request->only($metadataKeys),
            fn ($v) => $v !== null && $v !== ''
        );

        Inquiry::create([
            'form_type' => $formType,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'message' => $message,
            'metadata' => $metadata ?: null,
        ]);

        $redirectSlug = match ($formType) {
            'radio_ad' => 'radio-ad',
            'tailoring' => 'tailoring',
            'printing' => 'printing',
            'carpentry' => 'carpentry',
            'contact' => 'contact',
        };

        return redirect()
            ->route('forms.show', $redirectSlug)
            ->with('success', 'Thank you. We have received your submission and will get back to you soon.');
    }
}
