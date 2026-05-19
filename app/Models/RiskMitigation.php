<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskMitigation extends Model
{
    use HasFactory;

    protected $fillable = [
        'risk_id', 'assigned_to', 'action',
        'description', 'type', 'status', 'due_date',
    ];

    public function risk()
    {
        return $this->belongsTo(Risk::class);
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
