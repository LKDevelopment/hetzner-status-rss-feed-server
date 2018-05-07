<?php

namespace App\Providers;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('hetzner_ip', function ($attribute, $value, $parameters, $validator) {
            $client = new Client();
            $response = $client->get("https://get.geojs.io/v1/ip/geo/" . $value . ".json");

            $response = \GuzzleHttp\json_decode((string)$response->getBody());
            if (str_contains($response->organization, 'Hetzner')) {
                return true;
            } else {
                return false;
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
