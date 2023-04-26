<?php

namespace NotificationChannels\Madar;

use GuzzleHttp\Client as HttpClient;
use Illuminate\Support\ServiceProvider;

class MadarServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->app->when(MadarChannel::class)
            ->needs(Madar::class)
            ->give(function () {
                $username = config('madar.username');
                $password = config('madar.password');

                return new Madar(
                    $username,
                    $password,
                    new HttpClient()
                );
            });

        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__ . '/../config/madar.php' => config_path('madar.php'),], 'config');
            $this->publishes([
                __DIR__ . '/../lang/ar/response.php' => lang_path('ar/response.php'),
                __DIR__ . '/../lang/en/response.php' => lang_path('en/response.php'),
            ], 'lang');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
    }
}
