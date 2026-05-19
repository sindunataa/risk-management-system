<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RiskAssessmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this->id,
            'risk_id'          => $this->risk_id,
            'likelihood_score' => $this->likelihood_score,
            'impact_score'     => $this->impact_score,
            'risk_score'       => $this->risk_score,
            'notes'            => $this->notes,
            'assessed_at'      => $this->assessed_at,
            'assessor'         => new UserResource($this->whenLoaded('assessor')),
        ];

    }
}
