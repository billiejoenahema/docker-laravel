<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tag\StoreRequest;
use App\Http\Resources\Api\TagResource;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        dump($request);
        $tag = Tag::create([
            'name' => $request['name'],
            'user_id' => Auth::user()->id
        ]);

        return new TagResource($tag);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
