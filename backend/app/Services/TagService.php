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
     * タグを削除する。
     *
     * @param UpdateRequest $request
     * @return JsonResponse
     */
    public static function deleteTag($tag)
    {
        // 紐づくメモが存在しなければ実行する
        if($tag->memos()->doesntExist()) {
            $tag->delete();
            return response()->json(['message' => 'Tag deleted successfully'], 200);
        }
        return response()->json([
            'error_message' => 'Cannot be deleted because of the existence of a memo associated with it.'
        ]);
    }
}
