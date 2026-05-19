<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRiskAssessmentRequest;
use App\Http\Resources\RiskAssessmentResource;
use App\Models\Risk;
use App\Models\RiskAssessment;
use App\Traits\ApiResponse;

class RiskAssessmentController extends Controller
{
    use ApiResponse;

    public function store(StoreRiskAssessmentRequest $request, Risk $risk)
    {
        $assessment = $risk->assessments()->create([
            ...$request->validated(),
            'assessed_by' => auth()->id(),
            'risk_score'  => $request->likelihood_score * $request->impact_score,
        ]);

        $assessment->load('assessor');

        return $this->successResponse(
            new RiskAssessmentResource($assessment),
            'Assessment created',
            201
        );
    }

    public function index(Risk $risk)
    {
        $assessments = $risk->assessments()->with('assessor')->latest()->get();
        return $this->successResponse(RiskAssessmentResource::collection($assessments));
    }

    public function destroy(Risk $risk, RiskAssessment $assessment)
    {
        $assessment->delete();
        return $this->successResponse(null, 'Assessment deleted');
    }
}
