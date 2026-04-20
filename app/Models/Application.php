<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Application extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'application_number',
        'entity_type',
        'applicant_name',
        'phone',
        'email',
        'nationality',
        'address',
        'gender',
        'brand_name',
        'logo_path',
        'description',
        'industry',
        'usage_type',
        'first_use_date',
        'currently_selling',
        'website',
        'status',
        'trademark_status',
        'rejection_reason',
        'filed_at',
        'registered_at',
        'classes',
        'goods_services',
        'usage',
        'members_details',
    ];

    protected $casts = [
        'filed_at' => 'datetime',
        'registered_at' => 'datetime',
        'first_use_date' => 'date',
        'currently_selling' => 'boolean',
        'classes' => 'array',
        'members_details' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
