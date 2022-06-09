<?php

namespace App\Services;

use App\Models\Memo;
use Illuminate\Support\Facades\Auth;

class MemoService
{
    /**
     * メモ一覧をソートする。
     *
     * @param IndexRequest $request
     * @return Memo
     */
    public static function sortMemos($query, $request)
    {
        $memos = $query->when($request['sort'],function($q) use ($request) {
            $q->orderBy($request->getColumn(), $request->getOrder());
        })->get();

        return $memos;
    }

    /**
     * メモを登録する。
     *
     * @param StoreRequest $request
     * @return
     */
    public static function storeMemo($request)
    {
        $memo = Memo::create([
            'title' => $request['title'],
            'content' => $request['content'],
            'user_id' => Auth::user()->id,
        ]);
        $memo->tags()->sync($request['tag_ids']);

        return $memo;
    }

    /**
     * メモを更新する。
     *
     * @param UpdateRequest $request
     * @return
     */
    public static function updateMemo($request)
    {
        $user = Auth::user();
        $memo = Memo::findOrFail($request['id']);
        $memo->user_id = $user->id;
        $memo->title = $request['title'];
        $memo->content = $request['content'];
        $memo->save();
        $memo->tags()->sync($request->getTagIds());

        return $memo;
    }
}
