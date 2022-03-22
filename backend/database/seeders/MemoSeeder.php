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
            'content' => 'テストメモ1',
            'user_id' => '1',
        ]);

        $memo->tags()->attach($tag->id);
    }
}
