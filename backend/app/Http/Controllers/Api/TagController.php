<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tag\StoreRequest;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use App\Services\TagService;
use Illuminate\Http\Request;
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
        $tags = Tag::get();
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
     * @param  Tag $tag
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function detach(Tag $tag, Request $request)
    {
        DB::transaction(function () use ($tag, $request) {
            $tag->memos()->detach($request['memoId']);
        });

        return response()->json(['message' => 'Tag detached successfully'], 200);
    }

    /**
     * タグを削除する。
     *
     * @param  Tag $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag, TagService $tagService)
    {
        $response = $tagService->deleteTag($tag);

        return $response;
    }
}
