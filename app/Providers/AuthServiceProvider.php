<?php

namespace App\Providers;

use App\User;
use App\Menu;
use App\Quesition;
use App\Paper;
use App\Policies\MenuPolicy;
use App\Policies\UserPolicy;
use App\Policies\QuesitionPolicy;
use App\Policies\PaperPolicy;
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
        User::class => UserPolicy::class,
        Quesition::class => QuesitionPolicy::class,
        Paper::class => PaperPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    
       
        //
    }
}
