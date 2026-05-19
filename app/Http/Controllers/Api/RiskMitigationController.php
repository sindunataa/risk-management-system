<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRiskMitigationRequest;
use App\Http\Resources\RiskMitigationResource;
use App\Models\Risk;
use App\Models\RiskMitigation;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class RiskMitigationController extends Controller
{
   use ApiResponse;

    public function store(StoreRiskMitigationRequest $request, Risk $risk)
    {
        $mitigation = $risk->mitigations()->create($request->validated());
        $mitigation->load('assignee');

        return $this->successResponse(
            new RiskMitigationResource($mitigation),
            'Mitigation created',
            201
        );
    }

    public function index(Risk $risk)
    {
        $mitigations = $risk->mitigations()->with('assignee')->get();
        return $this->successResponse(RiskMitigationResource::collection($mitigations));
    }

    public function update(Request $request, Risk $risk, RiskMitigation $mitigation)
    {
        $mitigation->update($request->validate([
            'status' => 'required|in:planned,in_progress,completed',
        ]));

        return $this->successResponse(
            new RiskMitigationResource($mitigation),
            'Mitigation updated'
        );
    }

    public function destroy(Risk $risk, RiskMitigation $mitigation)
    {
        $mitigation->delete();
        return $this->successResponse(null, 'Mitigation deleted');
    }
}
