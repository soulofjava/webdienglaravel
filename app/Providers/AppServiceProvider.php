<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        ini_set('unserialize_callback_func', 'spl_autoload_call');

        if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
            URL::forceScheme('https');
        } elseif (request()->isSecure() || str_contains(request()->header('host', ''), 'trycloudflare.com')) {
            URL::forceScheme('https');
        }

        $viewPath = config('view.compiled');
        if ($viewPath && !is_dir($viewPath)) {
            @mkdir($viewPath, 0755, true);
        }
    }
}
