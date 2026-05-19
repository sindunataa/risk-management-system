<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRiskAssessmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'likelihood_score' => 'required|integer|min:1|max:5',
            'impact_score'     => 'required|integer|min:1|max:5',
            'notes'            => 'nullable|string',
            'assessed_at'      => 'required|date',
        ];
    }
}
