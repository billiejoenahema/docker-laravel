<?php

namespace App\Services;

use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

class TagService
{
    /**
     * タグを登録する。
     *
     * @param StoreRequest  $request
     * @return
     */
    public static function storeTag($request)
    {
        $tag = Tag::create([
            'name' => $request['name'],
            'user_id' => Auth::user()->id
        ]);

        return $tag;
    }

    /**
     * タグを更新する。
     *
     * @param \Illuminate\Http\Request $request
     * @return
     */
    public static function updateTag($request)
    {
        $tag = Tag::findOrFail($request->id);

        return $tag;
    }

    /**
     * 指定したメモからタグを外す。
     *
     * @param UpdateRequest $request
     * @return
     */
    public static function detachTag($request)
    {

    }

    /**
     * タグを削除する。
     *
     * @param UpdateRequest $request
     * @return
     */
    public static function deleteTag($request)
    {

    }
}
