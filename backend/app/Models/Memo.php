<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Memo extends Model
{
    use HasFactory;

    public function getMyMemo()
    {
        $query_tag = \Request::query('tag');

        // get all memo
        $query = Memo::query()->select('memos.*')
            ->where('user_id', '=', \Auth::id())
            ->whereNull('deleted_at')
            ->orderBy('updated_at', 'DESC');

        // narrow down memo with tags
        if (!empty($query_tag)) {
            $query->leftJoin('memo_tags', 'memo_tags.memo_id', '=', 'memos.id')
                ->where('memo_tags.tag_id', '=', $query_tag);
        }

        $memos = $query->get();

        return $memos;
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
        return $this->belongsToMany(Tag::class, 'memo_tags');
    }
}
