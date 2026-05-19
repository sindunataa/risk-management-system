<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RiskMitigationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'risk_id'     => $this->risk_id,
            'action'      => $this->action,
            'description' => $this->description,
            'type'        => $this->type,
            'status'      => $this->status,
            'due_date'    => $this->due_date,
            'assignee'    => new UserResource($this->whenLoaded('assignee')),
        ];
    }
}
