<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class AuthUserScope implements Scope
{
    /**
     * 指定のEloquentクエリビルダにスコープを適用
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->where('user_id', '=', Auth::id());
    }
}
