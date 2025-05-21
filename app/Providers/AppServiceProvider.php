<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

use function PHPSTORM_META\type;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //only writer role can create post
        Gate::define('create-post', function(User $user){
            return $user->type == "writer";
        });

        //only for admins
        Gate::define('admin-control', function(User $user){
            return $user->type == "admin";
        });
         
        //user who created the post only one who can edit it
        Gate::define('update-post', function(User $user, Post $post){
            return $user->id == $post->user_id;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
    }
}
