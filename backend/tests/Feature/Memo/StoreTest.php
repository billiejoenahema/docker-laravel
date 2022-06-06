<?php

namespace Tests\Feature\Memo;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    /**
     * メモを登録できるかどうか
     *
     * @return void
     */
    public function test_postMemo()
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();
        $tag = Tag::factory()->count(3)->create();

        // 実行
        $response = $this->actingAs($user)->postJson('/api/memos', [
            'user_id' => $user->id,
            'title' => 'テストタイトル',
            'content' => 'テストコメント',
            'tag_ids' => $tag->pluck('id')->toArray(),
        ]);
        $response
        ->assertCreated();

        $this->assertDatabaseCount('memos', 1);
    }
}
