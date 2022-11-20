<?php

namespace App\Models;

use App\Models\Scopes\AuthUserScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
    ];

    /**
     * モデルの「起動」メソッド
     *
     * ログインユーザーの所有するタグのみに絞り込むスコープを適用する
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new AuthUserScope);
    }

    /**
     * 紐づくメモ一覧を取得する
     */
    public function memos()
    {
        return $this->belongsToMany(Memo::class);
    }
}
