<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tag\StoreRequest;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
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
     * Store a newly created resource in storage.
     *
     * @param  StoreRequest
     * @return TagResource
     */
    public function store(StoreRequest $request)
    {
        $tag = Tag::create([
            'name' => $request['name'],
            'user_id' => Auth::user()->id
        ]);

        return new TagResource($tag);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $tag = DB::transaction(function () use ($request) {
            $tag = Tag::findOrFail($request->id);
            $tag->name = $request->name;
            $tag->save();
            return $tag;
        });

        return new TagResource($tag);
    }

    /**
     * Remove tag related the memo.
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
     * Remove the specified resource from storage.
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
