<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\GoogleDriveService;
use Google\Client;
use Google\Service\Drive;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Google Drive Service
        $this->app->singleton(GoogleDriveService::class, function ($app) {
            $client = new Client();
            $client->setClientId(config('google-drive.client_id'));
            $client->setClientSecret(config('google-drive.client_secret'));
            $client->refreshToken(config('google-drive.refresh_token'));

            $driveService = new Drive($client);

            return new GoogleDriveService($driveService);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
