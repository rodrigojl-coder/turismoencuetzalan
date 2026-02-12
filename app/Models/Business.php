<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BusinessType;

class Business extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'business_type_id',
        'name',
        'slug',
        'description',
        'price_from',
        'phone',
        'email',
        'address',
        'website',
        'images',
        'featured_image_index',
        'is_active',
        'type',
    ];

    protected $casts = [
        'images' => 'array', // Para manejar JSON automáticamente
        'is_active' => 'boolean',
    ];

    // Relación: un negocio pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function businesses()
{
    return $this->hasMany(Business::class);
}

    // Relación: un negocio tiene muchos items
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    // Relación con BusinessType
    public function businessType()
    {
        return $this->belongsTo(BusinessType::class);
    }

public function scopeActive($query)
{
    return $query->where('is_active', true);
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
