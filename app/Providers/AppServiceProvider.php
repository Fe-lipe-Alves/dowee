<?php

namespace App\Providers;

use App\Repositories\Contracts\PlaylistRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\PlaylistRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(PlaylistRepositoryInterface::class, PlaylistRepository::class);
    }
}
