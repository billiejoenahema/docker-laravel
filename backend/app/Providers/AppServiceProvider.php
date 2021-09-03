<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// use Illuminate\Support\Facades\DB;
use App\Models\Memo;
use App\Models\Tag;
// use App\Models\MemoTag;

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

            $memo_model = new Memo();

            // get memo list
            $memos = $memo_model->getMyMemo();

            // get all tag
            $tags = Tag::where('user_id', '=', \Auth::id())
                ->whereNull('deleted_at')
                ->orderBy('id', 'DESC')
                ->get();

            $view->with('memos', $memos)->with('tags', $tags);
        });
    }
}
