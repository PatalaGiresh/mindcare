<?php

namespace App\Providers;

use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        // Use standard pagination views
        Paginator::defaultView('pagination::default');
        Paginator::defaultSimpleView('pagination::simple-default');

        // Share data with ALL views (demonstrating View::share)
        View::composer('*', function ($view) {
            $user = Auth::user();

            $unreadMessages = 0;
            $pendingVerification = false;

            if ($user) {
                $unreadMessages = Message::where('receiver_id', $user->id)
                    ->whereNull('read_at')
                    ->count();

                if ($user->isTherapist() && $user->therapistProfile) {
                    $pendingVerification = !$user->therapistProfile->is_verified;
                }
            }

            $view->with([
                'authUser'           => $user,
                'globalUnreadCount'  => $unreadMessages,
                'needsVerification'  => $pendingVerification,
                'appName'            => config('app.name'),
            ]);
        });
    }
}
