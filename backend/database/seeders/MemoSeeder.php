<?php

namespace Database\Seeders;

use App\Models\Memo;
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
        Memo::create([
            'content' => 'テストメモ1',
            'user_id' => '1',
        ]);
    }
}
