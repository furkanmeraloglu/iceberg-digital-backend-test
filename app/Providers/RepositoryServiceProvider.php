<?php

namespace App\Providers;

use App\Repository\Interfaces\AppointmentRepositoryInterface;
use App\Repository\Interfaces\ContactRepositoryInterface;
use App\Repository\Interfaces\UserRepositoryInterface;
use App\Repository\Repositories\AppointmentRepository;
use App\Repository\Repositories\ContactRepository;
use App\Repository\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register() : void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(AppointmentRepositoryInterface::class, AppointmentRepository::class);
        $this->app->bind(ContactRepositoryInterface::class, ContactRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
