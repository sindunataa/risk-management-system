<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRiskRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'         => 'required|string|max:255',
            'description'   => 'required|string',
            'category_id'   => 'required',
            'likelihood'    => 'required|in:rare,unlikely,possible,likely,almost_certain',
            'impact'        => 'required|in:insignificant,minor,moderate,major,catastrophic',
            'status'        => 'sometimes|in:open,in_progress,mitigated,closed',
            'identified_at' => 'required|date',
        ];
    }
}
