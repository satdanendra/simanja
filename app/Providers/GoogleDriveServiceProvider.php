<?php

namespace App\Providers;

// use Google\Client;
// use Google\Service\Drive;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage;
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

        if (!config('services.google.client_id') || !config('services.google.client_secret')) {
            return;
        }

        $this->app->singleton(\Google\Client::class, function ($app) {
            $client = new \Google\Client();
            $client->setClientId(config('services.google.client_id'));
            $client->setClientSecret(config('services.google.client_secret'));
            $client->setRedirectUri(url('/auth/google/callback'));
            $client->setScopes([\Google\Service\Drive::DRIVE]);
            $client->setAccessType('offline');
            $client->setPrompt('consent');

            if (config('services.google.refresh_token')) {
                $client->refreshToken(config('services.google.refresh_token'));
            }

            return $client;
        });

        $this->app->singleton(\Google\Service\Drive::class, function ($app) {
            $client = $app->make(\Google\Client::class);
            return new \Google\Service\Drive($client);
        });
    }

    public function boot()
    {
        // Only run this in web requests, not in CLI (artisan)
        if (App::runningInConsole()) {
            return;
        }

        // Make sure required classes exist
        if (!class_exists(\Google\Client::class)) {
            return;
        }

        // Check if config is available
        if (!config('services.google.client_id') || !config('services.google.client_secret')) {
            return;
        }

        // Register Google Client as a singleton
        $this->app->singleton(\Google\Client::class, function ($app) {
            $client = new \Google\Client();
            $client->setClientId(config('services.google.client_id'));
            $client->setClientSecret(config('services.google.client_secret'));
            $client->setRedirectUri(url('/auth/google/callback'));
            $client->setScopes([\Google\Service\Drive::DRIVE]);
            $client->setAccessType('offline');
            $client->setPrompt('consent');

            if (config('services.google.refresh_token')) {
                $client->refreshToken(config('services.google.refresh_token'));
            }

            return $client;
        });

        // Register Google Drive service
        $this->app->singleton(\Google\Service\Drive::class, function ($app) {
            $client = $app->make(\Google\Client::class);
            return new \Google\Service\Drive($client);
        });

        // Add Google Drive to filesystem
        Storage::extend('google', function ($app, $config) {
            $client = $app->make(\Google\Client::class);
            $service = new \Google\Service\Drive($client);
            $adapter = new \Masbug\Flysystem\GoogleDriveAdapter($service, $config['folder']);
            
            return new \League\Flysystem\Filesystem($adapter);
        });
    }
}
