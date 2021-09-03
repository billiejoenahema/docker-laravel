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
            $query_tag = \Request::query('tag');

            if (!empty($query_tag)) {
                // narrow down memo with tags
                $memos = Memo::select('memos.*')
                    ->leftJoin('memo_tags', 'memo_tags.memo_id', '=', 'memos.id')
                    ->where('memo_tags.tag_id', '=', $query_tag)
                    ->where('user_id', '=', \Auth::id())
                    ->whereNull('deleted_at')
                    ->orderBy('updated_at', 'DESC')
                    ->get();
            } else {
                // get all memo
                $memos = Memo::select('memos.*')
                    ->where('user_id', '=', \Auth::id())
                    ->whereNull('deleted_at')
                    ->orderBy('updated_at', 'DESC')
                    ->get();
            }

            // get all tag
            $tags = Tag::where('user_id', '=', \Auth::id())
                ->whereNull('deleted_at')
                ->orderBy('id', 'DESC')
                ->get();

            $view->with('memos', $memos)->with('tags', $tags);
        });
    }
}
