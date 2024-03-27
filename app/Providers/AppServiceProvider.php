<?php

namespace App\Providers;

use App\Service\Url\LongUrlModifier\LongUrlModifier;
use App\Service\Url\LongUrlModifier\TrimFragmentModifier;
use App\Service\Url\LongUrlModifier\TrimTrailingSlashModifier;
use App\Service\Url\UrlMapper;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->tag([
            TrimTrailingSlashModifier::class,
            TrimFragmentModifier::class,
        ], 'longUrlModifiers');

        $this->app->when(UrlMapper::class)
            ->needs(LongUrlModifier::class)
            ->giveTagged('longUrlModifiers');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
