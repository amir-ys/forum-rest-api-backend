<?php

namespace App\Providers;

use App\Models\Answer;
use App\Models\Channel;
use App\Models\Permission;
use App\Models\Thread;
use App\Models\User;
use App\Policies\AnswerPolicy;
use App\Policies\ChannelPolicy;
use App\Policies\ThreadPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Channel::class => ChannelPolicy::class,
        Thread::class => ThreadPolicy::class,
        Answer::class => AnswerPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user) {
            return $user->hasPermissionTo(Permission::PERMISSION_SUPER_ADMIN) ? true : null;
        });
    }
}
