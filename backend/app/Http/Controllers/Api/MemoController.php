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
    public function index(IndexRequest $request, Memo $memo)
    {
        $query = Memo::with('tags')->where('user_id', '=', Auth::user()->id);

        // タグで絞り込み
        $query = $memo->filterByTag($query, $request['tag_ids']);

        // 検索ワードで絞り込み
        $query = $memo->filterBySearchWord($query, $request['search_word']);

        // ソート
        $memos = $memo->sortByRequest($query, $request->getSortColumn(), $request->getSortOrder())->get();

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
