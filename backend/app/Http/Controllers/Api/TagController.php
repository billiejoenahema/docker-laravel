<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tag\StoreRequest;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use App\Services\TagService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
    /**
     * タグ一覧を取得する。
     *
     * @return TagResource
     */
    public function index()
    {
        $query = Tag::where('user_id', Auth::user()->id);
        $tags = $query->get();
        return TagResource::collection($tags);
    }

    /**
     * タグを新規作成する。
     *
     * @param  StoreRequest
     * @return TagResource
     */
    public function store(StoreRequest $request, TagService $tagService)
    {
        $tag = $tagService->storeTag($request);
        return new TagResource($tag);
    }

    /**
     * タグを更新する。
     *
     * @param  \Illuminate\Http\Request  $request
     * @return TagResource
     */
    public function update(Request $request, TagService $tagService)
    {
        $tag = $tagService->updateTag($request);
        return new TagResource($tag);
    }

    /**
     * 指定したメモからタグを外す。
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function detach($id, Request $request)
    {
        DB::transaction(function () use ($id, $request) {
            $tag = Tag::findOrFail($id);
            $tag->memos()->detach($request['memoId']);
        });

        return response()->json(['message' => 'Tag detached successfully'], 200);
    }

    /**
     * タグを削除する。
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);

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
