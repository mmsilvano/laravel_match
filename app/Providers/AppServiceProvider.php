<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Model::preventLazyLoading(! app()->isProduction());

        View::composer('layouts.navigation', function ($view): void {
            /** @var ?User $user */
            $user = auth()->user();

            if ($user === null) {
                $view->with('navigationUnreadCount', 0);

                return;
            }

            $view->with('navigationUnreadCount', Message::query()
                ->whereNull('read_at')
                ->where('sender_id', '!=', $user->getKey())
                ->whereHas('conversation', fn ($query) => $query
                    ->where('user_one_id', $user->getKey())
                    ->orWhere('user_two_id', $user->getKey()))
                ->count());
        });
    }
}
