<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRiskRequest;
use App\Http\Requests\UpdateRiskRequest;
use App\Http\Resources\RiskResource;
use App\Models\Risk;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class RiskController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $risks = Risk::with(['category', 'owner'])
            ->when($request->status,      fn($q) => $q->where('status', $request->status))
            ->when($request->category_id, fn($q) => $q->where('category_id', $request->category_id))
            ->when($request->risk_level,  fn($q) => $this->filterByRiskLevel($q, $request->risk_level))
            ->when($request->search,      fn($q) => $q->where('title', 'like', "%{$request->search}%"))
            ->latest()
            ->paginate($request->per_page ?? 10);

        return $this->paginatedResponse(
            RiskResource::collection($risks)->resource,
            'Risks retrieved'
        );
    }

    public function store(StoreRiskRequest $request)
    {
        $risk = Risk::create([
            ...$request->validated(),
            'owner_id' => auth()->id(),
        ]);

        $risk->load(['category', 'owner']);

        return $this->successResponse(
            new RiskResource($risk),
            'Risk created',
            201
        );
    }

    public function show(Risk $risk)
    {
        $risk->load(['category', 'owner', 'assessments.assessor', 'mitigations.assignee']);
        return $this->successResponse(new RiskResource($risk));
    }

    public function update(UpdateRiskRequest $request, Risk $risk)
    {
        $risk->update($request->validated());
        // $risk->load(['category', 'owner']);

        return $this->successResponse(new RiskResource($risk), 'Risk updated');
    }

    public function destroy(Risk $risk)
    {
        $risk->delete();
        return $this->successResponse(null, 'Risk deleted');
    }

    private function filterByRiskLevel($query, string $level)
    {
        $ranges = [
            'critical' => [20, 25],
            'high'     => [12, 19],
            'medium'   => [6, 11],
            'low'      => [1, 5],
        ];

        if (!isset($ranges[$level])) return $query;

        // ambil semua lalu filter (karena risk_score adalah computed)
        return $query->get()->filter(
            fn($r) => $r->risk_score >= $ranges[$level][0]
                   && $r->risk_score <= $ranges[$level][1]
        );
    }
}
