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
        $memos = Memo::select('memos.*')
            ->where('user_id', '=', \Auth::id())
            ->whereNull('deleted_at')
            ->orderBy('updated_at', 'DESC')
            ->get();
        return view('create', compact('memos'));
    }

    public function store(Request $request)
    {
        $posts = $request->all();

        DB::transaction(function () use ($posts) {
            $memo_id = Memo::insertGetId(
                [
                    'content' => $posts['content'],
                    'user_id' => \Auth::id()
                ]
            );
            $tag_exists = Tag::where('user_id', '=', \Auth::id())
                ->where('name', '=', $posts['new_tag'])
                ->exists();
            // タグが入力されていて、既存タグと重複していなければ処理を進める
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
        }, 5); // 第2引数 = デッドロックが発生した時の再試行回数

        return redirect(route('home'));
    }

    public function edit($id)
    {
        $memos = Memo::select('memos.*')
            ->where('user_id', '=', \Auth::id())
            ->whereNull('deleted_at')
            ->orderBy('updated_at', 'DESC')
            ->get();

        $edit_memo = Memo::find($id);
        return view('edit', compact('memos', 'edit_memo'));
    }

    public function update(Request $request)
    {
        $posts = $request->all();

        Memo::where('id', $posts['memo_id'])->update(
            [
                'content' => $posts['content'],
                'user_id' => \Auth::id()
            ]
        );
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
