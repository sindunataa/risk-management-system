<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Risk extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title', 'description', 'category_id', 'owner_id',
        'likelihood', 'impact', 'status', 'identified_at',
    ];

    protected $appends = ['risk_score', 'risk_level'];

    const LIKELIHOOD_MAP = [
        'rare' => 1, 'unlikely' => 2, 'possible' => 3,
        'likely' => 4, 'almost_certain' => 5,
    ];

    const IMPACT_MAP = [
        'insignificant' => 1, 'minor' => 2, 'moderate' => 3,
        'major' => 4, 'catastrophic' => 5,
    ];

    public function getRiskScoreAttribute(): int
    {
        return self::LIKELIHOOD_MAP[$this->likelihood]
             * self::IMPACT_MAP[$this->impact];
    }

    public function getRiskLevelAttribute(): string
    {
        return match(true) {
            $this->risk_score >= 20 => 'Critical',
            $this->risk_score >= 12 => 'High',
            $this->risk_score >= 6  => 'Medium',
            default                 => 'Low',
        };
    }

    public function category()
    {
        return $this->belongsTo(RiskCategory::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function assessments()
    {
        return $this->hasMany(RiskAssessment::class);
    }

    public function mitigations()
    {
        return $this->hasMany(RiskMitigation::class);
    }
}
