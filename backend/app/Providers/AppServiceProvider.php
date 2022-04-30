<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Memo;
use App\Models\Tag;

class AppServiceProvider extends ServiceProvider
{
    /**
     * アプリケーションのポリシーマッピング
     *
     * @var array
     */
    protected $policies = [
        Memo::class => MemoPolicy::class,
        Tag::class => TagPolicy::class,
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
