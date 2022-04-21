<?php

namespace Database\Seeders;

use App\Models\Memo;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class MemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tag = Tag::create([
            'name' => 'テストタグ1',
            'user_id' => '1',
        ]);

        $memo = Memo::create([
            'title' => 'テストメモのタイトル',
            'content' => 'テストメモのコンテンツ',
            'user_id' => '1',
        ]);

        $memo->tags()->sync($tag->id);
    }
}
