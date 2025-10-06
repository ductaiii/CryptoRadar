<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // (superadmin, admin) xem toàn bộ user
        Gate::define('view-any-user', function (User $user) {
            return in_array($user->role, ['admin', 'superadmin']);
        });
        // superadmin : tạo user mới
        Gate::define('create-user', function (User $user) {
            return $user->role === 'superadmin';
        });
        // superadmin : xoá user
        Gate::define('delete-user', function (User $user) {
            return $user->role === 'superadmin';
        });
        // (superadmin, admin, user) sửa user (theo quyền)
        // Sửa user: superadmin sửa mọi user, admin sửa mọi user trừ superadmin, user chỉ sửa chính mình
        // User $target là user mục tiêu bị sửa
        Gate::define('update-user', function (User $user, User $target) {
            if ($user->role === 'superadmin') return true;
            if ($user->role === 'admin' && $target->role !== 'superadmin') return true;
            return $user->id === $target->id;
        });
        // (superadmin, admin) xem watchlist của user khác
        Gate::define('view-any-watchlist', function (User $user) {
            return in_array($user->role, ['admin', 'superadmin']);
        });

        // user chỉ xem watchlist của chính mình
        Gate::define('view-own', function (User $user, User $target) {
            return $user->id === $target->id;
        });


    }
}
