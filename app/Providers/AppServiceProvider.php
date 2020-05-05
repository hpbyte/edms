<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
// share
use \App\User;
use \App\Document;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        if(Schema::hasTable('users')){
            // requests number
            $numReq = count(User::where('status',false)->get());
            View::share('requests',$numReq);
        }
        if (Schema::hasTable('document')){
            // trash noti
            $trash = count(Document::where('isExpire',2)->get());
            View::share('trashfull',$trash);
        }

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
