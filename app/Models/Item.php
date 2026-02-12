<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'type',
        'name',
        'description',
        'price_low',
        'price_high',
        'quantity',
        'images',
        'featured_image_index',
        'is_active',
    ];

    protected $casts = [
        'images' => 'array',
        'is_active' => 'boolean',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    // Obtener imagen destacada o la primera disponible
    public function getFeaturedImage()
    {
        if (!$this->images || empty($this->images)) {
            return null;
        }
        
        if (!is_null($this->featured_image_index) && isset($this->images[$this->featured_image_index])) {
            return $this->images[$this->featured_image_index];
        }
        
        return $this->images[0];
    }
}
