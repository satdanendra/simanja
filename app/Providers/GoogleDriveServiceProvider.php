<?php

namespace App\Providers;

use Google_Client;
use Google_Service_Drive;
use Illuminate\Support\ServiceProvider;

class GoogleDriveServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Google_Client::class, function ($app) {
            $client = new Google_Client();
            $client->setClientId(config('google-drive.client_id'));
            $client->setClientSecret(config('google-drive.client_secret'));
            $client->setRedirectUri(url('/auth/google/callback'));
            $client->setScopes([Google_Service_Drive::DRIVE]);
            $client->setAccessType('offline');
            $client->setPrompt('consent');

            if (config('google-drive.refresh_token')) {
                $client->refreshToken(config('google-drive.refresh_token'));
            }

            return $client;
        });

        $this->app->singleton(Google_Service_Drive::class, function ($app) {
            $client = $app->make(Google_Client::class);
            return new Google_Service_Drive($client);
        });
    }
}