<?php

namespace App\Providers;

use App\Models\Car;
use App\Policies\CarPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        Car::class => CarPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
