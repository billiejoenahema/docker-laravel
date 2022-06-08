<?php

namespace Tests\Feature\Memo;

use App\Models\Memo;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * メモを更新できるかどうか
     *
     * @return void
     */
    public function test_updateMemo()
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();
        $tag = Tag::factory()->count(3)->create(['user_id' => $user->id]);
        $memo = Memo::factory()->create([
            'user_id' => $user->id,
        ]);
        $memo->tags()->sync($tag->pluck('id'));

        // 実行
        $response = $this->actingAs($user)->patchJson('/api/memos/' . $memo->id, [
            'id' => $memo->id,
            'user_id' => $user->id,
            'title' => 'テストタイトル',
            'content' => 'テストコンテント',
            'tags' => $tag,
        ]);
        $response->assertOk();

        $this->assertDatabaseHas('memos', [
            'id' => $memo->id,
            'user_id' => $user->id,
            'title' => 'テストタイトル',
            'content' => 'テストコンテント',
        ]);
        $this->assertDatabaseCount('memo_tag', 3);
    }
}
