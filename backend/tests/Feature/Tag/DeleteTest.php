<?php

namespace Tests\Feature\Tag;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_deleteTag()
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();
        $tag = Tag::factory()->create(['user_id' => $user->id]);

        // 実行
        $response = $this->actingAs($user)->deleteJson('/api/tags/' . $tag->id);
        $response->assertOk();

        $this->assertDatabaseMissing('tags', [
            'id' => $tag->id,
            'user_id' => $user->id,
        ]);
    }
}
