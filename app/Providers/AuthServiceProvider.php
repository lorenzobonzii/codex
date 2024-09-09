<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Role;
use App\Models\User;
use App\Models\Capability;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
    */
    public function boot(): void
    {
        $this->registerPolicies();

        $ruoli = Role::all();
        foreach ($ruoli as $ruolo){
            Gate::define($ruolo->nome, function(User $user) use ($ruolo){
                return $user->role->nome === $ruolo->nome;
            });
        }

        $capabilities = Capability::all();
        foreach ($capabilities as $capability){
            Gate::define($capability->nome, function(User $user) use ($capability){
                return $user->role->capabilities->contains('id',$capability->id);
            });
        }

    }
}
