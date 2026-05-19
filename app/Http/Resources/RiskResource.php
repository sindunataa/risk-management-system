<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RiskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'title'         => $this->title,
            'description'   => $this->description,
            'status'        => $this->status,
            'likelihood'    => $this->likelihood,
            'impact'        => $this->impact,
            'risk_score'    => $this->risk_score,
            'risk_level'    => $this->risk_level,
            'identified_at' => $this->identified_at,
            // 'category'      => new RiskCategoryResource($this->whenLoaded('category')),
            // 'owner'         => new UserResource($this->whenLoaded('owner')),
            // 'assessments'   => RiskAssessmentResource::collection($this->whenLoaded('assessments')),
            // 'mitigations'   => RiskMitigationResource::collection($this->whenLoaded('mitigations')),
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
        ];
    }
}
