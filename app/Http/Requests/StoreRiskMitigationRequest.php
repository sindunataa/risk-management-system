<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRiskMitigationRequest extends FormRequest
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
            'action'      => 'required|string|max:255',
            'description' => 'required|string',
            'type'        => 'required|in:avoid,reduce,transfer,accept',
            'status'      => 'sometimes|in:planned,in_progress,completed',
            'assigned_to' => 'required|exists:users,id',
            'due_date'    => 'required|date|after:today',
        ];
    }
}
