<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use App\Models\Memo;
use App\Models\Tag;
use App\Models\MemoTag;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view) {
            // get all memo
            $memos = Memo::select('memos.*')
                ->where('user_id', '=', \Auth::id())
                ->whereNull('deleted_at')
                ->orderBy('updated_at', 'DESC')
                ->get();

            $view->with('memos', $memos);
        });
    }
}
