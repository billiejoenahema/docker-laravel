<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Memo\IndexRequest;
use App\Http\Requests\Memo\StoreRequest;
use App\Http\Requests\Memo\UpdateRequest;
use App\Http\Resources\MemoResource;
use App\Models\Memo;
use App\Services\MemoService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MemoController extends Controller
{
    /**
     * メモ一覧を取得する。
     *
     * @param IndexRequest
     * @return MemoResource
     */
    public function index(IndexRequest $request, MemoService $memoService)
    {
        $query = Memo::with('tags')->where('user_id', '=', Auth::user()->id);
        $query->when($request['tag_ids'], function($q) use ($request) {
            return $q->whereHas('tags', function($q) use($request) {
                $q->whereIn('id', $request['tag_ids']);
            });
        })->when($request['search_word'], function($q) use ($request) {
            return $q->where('title', 'like', '%'. $request['search_word'] . '%')
            ->orWhere('content', 'like', '%'. $request['search_word'] . '%');
        });

        $memos = $memoService->sortMemos($query, $request);

        return MemoResource::collection($memos);
    }

    /**
     * メモを新規登録する。
     *
     * @param  StoreRequest  $request
     * @return MemoResource
     */
    public function store(StoreRequest $request, MemoService $memoService)
    {
        $memo = DB::transaction(function () use ($request, $memoService) {
            $memo = $memoService->storeMemo($request);
            return $memo;
        });

        return new MemoResource($memo);
    }

    /**
     * メモを更新する。
     *
     * @param  UpdateRequest $request
     * @return MemoResource
     */
    public function update(UpdateRequest $request, MemoService $memoService)
    {
        $memo = DB::transaction(function () use ($request, $memoService) {
            $memo = $memoService->updateMemo($request);
            return $memo;
        });

        return new MemoResource($memo);
    }

    /**
     * メモを削除する。
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $memo = Memo::findOrFail($id);
            $memo->tags()->detach($id);
            $memo->delete();
        });

        return response()->json(['message' => 'Memo deleted successfully'], 200);
    }
}
