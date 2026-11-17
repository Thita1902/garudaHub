<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $fillable = [
        'client_id',
        'title',
        'description',
        'category',
        'budget_min',
        'budget_max',
        'deadline',
        'status',
    ];

    protected $casts = [
        'deadline' => 'date',
    ];

    // Satu proyek dimiliki satu klien (user)
    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    // Satu proyek punya banyak penawaran
    public function bids(): HasMany
    {
        return $this->hasMany(Bid::class);
    }
}