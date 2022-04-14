<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Memo\IndexRequest;
use App\Http\Requests\Memo\StoreRequest;
use App\Http\Resources\Api\MemoResource;
use App\Models\Memo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MemoController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param IndexRequest
     * @return MemoResource
     */
    public function index(IndexRequest $request)
    {
        $query = Memo::with('tags')->where('user_id', '=', Auth::user()->id);
        $memos = $query->when($request['tag_ids'], function($q) use ($request) {
            return $q->whereHas('tags', function($q) use($request) {
                $q->whereIn('id', $request['tag_ids']);
            });
        })->when($request['search_word'], function($q) use ($request) {
            return $q->where('title', 'like', '%'. $request['search_word'] . '%');
        })->get();


        return MemoResource::collection($memos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRequest  $request
     * @return MemoResource
     */
    public function store(StoreRequest $request)
    {

        $memo = DB::transaction(function () use ($request) {
            $memo = Memo::create([
                'title' => $request['title'],
                'content' => $request['content'],
                'user_id' => Auth::user()->id,
            ]);
            $memo->tags()->sync($request['tag_ids']);

            return $memo;
        });

        return new MemoResource($memo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $memo = DB::transaction(function () use ($request) {
            $user = Auth::user();
            $memo = Memo::findOrFail($request['id']);

            $memo->user_id = $user->id;
            $memo->content = $request['content'];
            $memo->save();

            $memo->tags()->sync($request['tag_ids']);

            return $memo;
        });

        return new MemoResource($memo);
    }

    /**
     * Remove the specified resource from storage.
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
