<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bid extends Model
{
    protected $fillable = [
        'project_id',
        'developer_id',
        'price',
        'duration_days',
        'proposal',
        'status',
    ];

    // Satu penawaran milik satu proyek
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    // Satu penawaran dibuat oleh satu developer (user)
    public function developer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'developer_id');
    }
}