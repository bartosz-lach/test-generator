<?php

namespace App\Providers;

use App\Answer;
use App\Policies\AppPolicy;
use App\Question;
use App\Test;
use App\TestVersion;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        Test::class => AppPolicy::class,
        Question::class => AppPolicy::class,
        Answer::class => AppPolicy::class,
        TestVersion::class => AppPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Passport::routes();

        //
    }
}
