<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'risk_id', 'assessed_by', 'likelihood_score',
        'impact_score', 'risk_score', 'notes', 'assessed_at',
    ];

    public function risk()
    {
        return $this->belongsTo(Risk::class);
    }

    public function assessor()
    {
        return $this->belongsTo(User::class, 'assessed_by');
    }
}
