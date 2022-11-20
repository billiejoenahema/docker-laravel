<?php

namespace App\Models;

use App\Models\Scopes\AuthUserScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Memo extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'user_id',
    ];

    /**
     * モデルの「起動」メソッド
     *
     * ログインユーザーの所有するメモのみに絞り込むスコープを適用する
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new AuthUserScope);
    }

    /**
     * 紐づくユーザーを取得する
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 紐づくタグ一覧を取得する
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * メモ一覧をタグで絞り込む。
     *
     * @param \Illuminate\Database\Eloquent\Builder  $query
     * @param string $tagIds
     * @return Memo
     */
    public static function filterByTag($query, $tagIds)
    {
        return $query->when($tagIds, function ($q) use ($tagIds) {
            return $q->whereHas('tags', function ($q) use ($tagIds) {
                $q->whereIn('id', $tagIds);
            });
        });
    }

    /**
     * メモ一覧を検索ワードで絞り込む。
     *
     * @param \Illuminate\Database\Eloquent\Builder  $query
     * @param string $searchWord
     * @return Memo
     */
    public static function filterBySearchWord($query, $searchWord)
    {
        return $query->when($searchWord, function ($q) use ($searchWord) {
            return $q->where('title', 'like', '%' . $searchWord . '%')
                ->orWhere('content', 'like', '%' . $searchWord . '%');
        });
    }

    /**
     * メモ一覧をソートする。
     *
     * @param \Illuminate\Database\Eloquent\Builder  $query
     * @param string $sortColumn
     * @param string $sortOrder
     * @return Memo
     */
    public static function sortByRequest($query, $sortColumn, $sortOrder)
    {
        return $query->orderBy($sortColumn, $sortOrder);
    }
}
