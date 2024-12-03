<?php

namespace App\Providers;

use App\Policies\AdminUserPolicy;
use App\Policies\CarPolicy;
use App\Policies\LicensePlatePolicy;
use App\Policies\TypeCarPolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;


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
        //
        Paginator::useBootstrapFive();
        $this->defineGateTypeCar();
        $this->defineGateCar();
        $this->defineGateLicensePlate();
        $this->defineGateUser();
        $this->defineDashboardGate();
    }
    public function defineDashboardGate(){
        Gate::define('dashboard', function () {
            if(auth()->check()){
                return true;
            }
            return false;

        });
    }
    public function defineGateTypeCar(){
        Gate::define('typecar_list', [TypeCarPolicy::class, 'view']);
        Gate::define('typecar_add', [TypeCarPolicy::class, 'create']);
        Gate::define('typecar_edit', [TypeCarPolicy::class, 'update']);
        Gate::define('typecar_delete', [TypeCarPolicy::class, 'delete']);
    }
    public function defineGateCar(){
        Gate::define('car_list', [CarPolicy::class, 'view']);
        Gate::define('car_add', [CarPolicy::class, 'create']);
        Gate::define('car_edit', [CarPolicy::class, 'update']);
        Gate::define('car_delete', [CarPolicy::class, 'delete']);
    }
    public function defineGateLicensePlate(){
        Gate::define('licenseplate_list', [LicensePlatePolicy::class, 'view']);
        Gate::define('licenseplate_add', [LicensePlatePolicy::class, 'create']);
        Gate::define('licenseplate_edit', [LicensePlatePolicy::class, 'update']);
        Gate::define('licenseplate_delete', [LicensePlatePolicy::class, 'delete']);
    }
    public function defineGateUser(){
        Gate::define('user_list', [AdminUserPolicy::class, 'view']);
        Gate::define('user_add', [AdminUserPolicy::class, 'create']);
        Gate::define('user_edit', [AdminUserPolicy::class, 'update']);
        Gate::define('user_delete', [AdminUserPolicy::class, 'delete']);
    }
}
