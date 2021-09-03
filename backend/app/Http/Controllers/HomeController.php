<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Memo;
use App\Models\Tag;
use App\Models\MemoTag;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $tags = Tag::where('user_id', '=', \Auth::id())
            ->whereNull('deleted_at')
            ->orderBy('id', 'DESC')
            ->get();

        return view('create', compact('tags'));
    }

    public function store(Request $request)
    {
        $posts = $request->all();

        DB::transaction(function () use ($posts) {
            // get memo id
            $memo_id = Memo::insertGetId(
                [
                    'content' => $posts['content'],
                    'user_id' => \Auth::id()
                ]
            );
            // check existing new tag in Tag's table
            $tag_exists = Tag::where('user_id', '=', \Auth::id())
                ->where('name', '=', $posts['new_tag'])
                ->exists();

            // insert new tag into Tag & MemoTag's table
            if (!empty($posts['new_tag']) || $posts['new_tag'] === "0" && !$tag_exists) {
                $tag_id = Tag::insertGetId(
                    [
                        'user_id' => \Auth::id(),
                        'name' => $posts['new_tag']
                    ]
                );
                MemoTag::insert(
                    [
                        'memo_id' => $memo_id,
                        'tag_id' => $tag_id
                    ]
                );
            }

            // insert existing tags into MemoTag's table
            if (array_key_exists('tags', $posts)) {
                foreach ($posts['tags'] as $tag) {
                    MemoTag::insert(['memo_id' => $memo_id, 'tag_id' => $tag]);
                }
            }
        }, 5); // 第2引数 = デッドロックが発生した時の再試行回数

        return redirect(route('home'));
    }

    public function edit($id)
    {
        $edit_memo = Memo::select('memos.*', 'tags.id AS tag_id')
            ->leftJoin('memo_tags', 'memo_tags.memo_id', '=', 'memos.id')
            ->leftJoin('tags', 'memo_tags.tag_id', '=', 'tags.id')
            ->where('memos.user_id', '=', \Auth::id())
            ->where('memos.id', '=', $id)
            ->whereNull('memos.deleted_at')
            ->get();

        $include_tags = [];
        foreach ($edit_memo as $memo) {
            array_push($include_tags, $memo['tag_id']);
        }

        $tags = Tag::where('user_id', '=', \Auth::id())
            ->whereNull('deleted_at')
            ->orderBy('id', 'DESC')
            ->get();

        return view('edit', compact('edit_memo', 'include_tags', 'tags'));
    }

    public function update(Request $request)
    {
        $posts = $request->all();

        DB::transaction(function () use ($posts) {
            Memo::where('id', $posts['memo_id'])->update(
                [
                    'content' => $posts['content'],
                    'user_id' => \Auth::id()
                ]
            );

            MemoTag::where('memo_id', '=', $posts['memo_id'])->delete();
            foreach ($posts['tags'] as $tag) {
                MemoTag::insert(['memo_id' => $posts['memo_id'], 'tag_id' => $tag]);
            }

            // check existing new tag in Tag's table
            $tag_exists = Tag::where('user_id', '=', \Auth::id())
                ->where('name', '=', $posts['new_tag'])
                ->exists();

            // insert new tag into Tag & MemoTag's table
            if (!empty($posts['new_tag']) || $posts['new_tag'] === "0" && !$tag_exists) {
                $tag_id = Tag::insertGetId(
                    [
                        'user_id' => \Auth::id(),
                        'name' => $posts['new_tag']
                    ]
                );
                MemoTag::insert(
                    [
                        'memo_id' => $posts['memo_id'],
                        'tag_id' => $tag_id
                    ]
                );
            }
        });
        return redirect('home');
    }

    public function destroy(Request $request)
    {
        $posts = $request->all();

        Memo::where('id', $posts['memo_id'])
            ->update(['deleted_at' => date("Y-m-d H:i:s", time())]);
        return redirect('home');
    }
}
