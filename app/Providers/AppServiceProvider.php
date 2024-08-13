<?php

namespace App\Providers;


use App\Models\Report;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Debugbar', \Barryvdh\Debugbar\Facades\Debugbar::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('isAdmin', function (User $user) {
            return $user->role === 'admin';
        });

        Gate::define('edit-report', function (User $user, Report $report) {
            if ($user->role !== 'admin') {
                return $user->id === $report->user_id ?? redirect()->route('reports.my-reports');
            } else {
                return true;
            }
        });
    }
}
