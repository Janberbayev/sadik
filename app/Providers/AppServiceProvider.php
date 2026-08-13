<?php

namespace App\Providers;

use App\Models\SiteContact;
use App\Models\User;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        require_once dirname(__DIR__).'/helpers.php';
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.dashboard-navigation', function ($view) {
            $view->with([
                'pendingUsersCount' => User::query()
                    ->where('status', User::STATUS_PENDING)
                    ->count(),
            ]);
        });

        View::composer('layout.footer', function ($view) {
            $view->with(
                'footerContacts',
                SiteContact::forPublicPage(SiteContact::current())
            );
        });
    }
}
