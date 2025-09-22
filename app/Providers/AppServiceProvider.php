<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
        Paginator::useBootstrap();

        // Use Laravel's configured timezone with fallback to UTC
        $tz = config('app.timezone', 'UTC');

        try {
            $timezone = new \DateTimeZone($tz);
            $offset = $timezone->getOffset(new \DateTime('now', $timezone));
            $offsetHours = $offset / 3600;
            $offsetFormatted = sprintf('%+03d:00', $offsetHours);

            DB::statement("SET time_zone = ?", [$offsetFormatted]);
        } catch (\Exception $e) {
            // Fallback to UTC if invalid timezone
            DB::statement("SET time_zone = '+00:00'");
        }
    }
}
