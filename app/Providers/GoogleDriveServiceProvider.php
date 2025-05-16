<?php

namespace App\Providers;

// use Google\Client;
// use Google\Service\Drive;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;

class GoogleDriveServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Jangan load Google Drive saat sedang di CLI (misal php artisan)
        if (App::runningInConsole()) {
            return;
        }

        if (!class_exists(\Google\Client::class)) {
            return;
        }

        if (!config('google-drive.client_id') || !config('google-drive.client_secret')) {
            return;
        }

        $this->app->singleton(\Google\Client::class, function ($app) {
            $client = new \Google\Client();
            $client->setClientId(config('google-drive.client_id'));
            $client->setClientSecret(config('google-drive.client_secret'));
            $client->setRedirectUri(url('/auth/google/callback'));
            $client->setScopes([\Google\Service\Drive::DRIVE]);
            $client->setAccessType('offline');
            $client->setPrompt('consent');

            if (config('google-drive.refresh_token')) {
                $client->refreshToken(config('google-drive.refresh_token'));
            }

            return $client;
        });

        $this->app->singleton(\Google\Service\Drive::class, function ($app) {
            $client = $app->make(\Google\Client::class);
            return new \Google\Service\Drive($client);
        });
    }
}
