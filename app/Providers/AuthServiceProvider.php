<?php

namespace App\Providers;

use App\Prod;
use App\Policies\ProdPolicy;
use App\Policies\NewProdPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
         // UserIsAdmin::foo();
        // exit();
        // $bar = class_exists('ProdPolicy');
        // echo "<pre>";
        // var_dump($bar);
        // exit();
        $this->registerPolicies();

        //
    }
}
