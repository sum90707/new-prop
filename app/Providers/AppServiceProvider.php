<?php

namespace App\Providers;

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
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $mapList = array(
            'UserRepositoryInterface' => 'UserRepository',
            'QuizRepositoryInterface' => 'QuizRepository',
            'QuesitionRepositoryInterface' => 'QuesitionRepository',
            'UserQuizRepositoryInterface' => 'UserQuizRepository'
        );

        foreach ($mapList as $intreface => $entity) {
            $this->app->bind("App\Repositories\Interfaces\\$intreface", "App\Repositories\\$entity");
        }
    }
}
