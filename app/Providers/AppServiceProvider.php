<?php

namespace App\Providers;

use App\Mail\MailerooTransport;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ServiceProvider;

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
        Mail::extend('maileroo', function (array $config = []) {
            return new MailerooTransport(
                apiKey: $config['api_key'] ?? config('services.maileroo.api_key'),
                baseUrl: $config['base_url'] ?? config('services.maileroo.base_url'),
            );
        });
    }
}
