<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BusinessType extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

    // Mutator to set slug automatically when name is set
    protected static function booted()
    {
        static::creating(function ($model) {
            if (!$model->slug && $model->name) {
                $model->slug = Str::slug($model->name);
            }
        });
    }

    public function businesses()
    {
        return $this->hasMany(\App\Models\Business::class, 'business_type_id');
    }
}
