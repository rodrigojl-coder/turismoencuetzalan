<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BusinessItem extends Model
{
    protected $fillable = [
        'business_id',
        'type',
        'name',
        'slug',
        'description',
        'price_low',
        'price_high',
        'quantity',
        'images',
        'is_active',
    ];

    protected $casts = [
        'images' => 'array',
        'is_active' => 'boolean',
    ];

    // Relación con negocio
    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    // Genera slug automáticamente
    public static function boot()
    {
        parent::boot();
        static::creating(function ($item) {
            $item->slug = Str::slug($item->name);
        });
        static::updating(function ($item) {
            $item->slug = Str::slug($item->name);
        });
    }
}
