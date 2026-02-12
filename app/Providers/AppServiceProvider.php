<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\BusinessType;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Compartir en todas las vistas los grupos de menú basados en tipos existentes
        try {
            $categories = [
                'Hospedajes' => ['hotel','cabana','cabaña','hostal'],
                'Alimentos' => ['restaurante','cafeteria','comedor','comedor'],
            ];

            $menuGroups = [];

            foreach ($categories as $label => $slugs) {
                // normalizar slugs
                $norm = array_map(function($s){ return Str::slug($s); }, $slugs);
                $types = BusinessType::whereIn('slug', $norm)
                    ->whereHas('businesses')
                    ->orderBy('name')
                    ->get();

                if ($types->isNotEmpty()) {
                    $menuGroups[$label] = $types;
                }
            }

            View::share('menuGroups', $menuGroups);
        } catch (\Throwable $e) {
            // en entorno de instalación o sin DB, no romper la app
            View::share('menuGroups', []);
        }
    }
}
