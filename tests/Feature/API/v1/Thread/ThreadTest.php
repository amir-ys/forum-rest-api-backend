<?php

namespace Tests\Feature\API\v1\Thread;

use App\Models\Channel;
use App\Models\Permission;
use App\Models\Thread;
use App\Models\User;
use Database\Seeders\RolePermissionsTableSeeder;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_threads_should_be_accessible()
    {
        $this->getJson(route('threads.index'))->assertStatus(Response::HTTP_OK);
    }

    public function test_a_thread_should_be_accessible_with_slug()
    {
        $thread = $this->createThread();
        $this->getJson(route('threads.show', $thread->slug))->assertStatus(Response::HTTP_OK);
    }

    public function test_can_create_thread()
    {
        $this->withoutExceptionHandling();
        $this->actAsUser();
        $this->postJson(route('threads.store'), [
            'title' => 'laravel',
            'content' => 'test thread laravel',
            'channel_id' => $this->createChannel()->id,
        ])->assertStatus(Response::HTTP_CREATED);
        self::assertEquals(1 , Thread::count());
    }

    public function test_thread_creating_should_be_validated()
    {
        $this->actAsUser();
        $this->postJson(route('threads.store'), [])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_can_update_own_thread()
    {
        $this->actAsUser();
        $thread = $this->createThread();
        $this->patchJson(route('threads.update', $thread->id), [
            'title' => 'vuejs',
            'slug' => 'vuejs',
            'content' => 'how learn vuejs ?',
            'user_id' => auth()->id(),
            'channel_id' => $this->createChannel()->id
        ])->assertStatus(200);
        $this->assertEquals('vuejs', $thread->fresh()->title);

        $this->actAsUser();
        $thread = $this->createThread();
        $this->patchJson(route('threads.update', $thread->id), [
            'best_answer_id' => 1,
        ])->assertStatus(200);

        $this->assertEquals('1', $thread->fresh()->best_answer_id);
    }

    public function test_user_can_not_update_other_thread()
    {
        $thread = $this->createThread();
        $newUser = $this->actAsUser();
        $this->patchJson(route('threads.update', $thread->id), [
            'title' => 'vuejs',
            'slug' => 'vuejs2',
            'content' => 'how learn vuejs ?',
            'user_id' => $thread->user_id ,
            'channel_id' => $this->createChannel()->id
        ])->assertStatus(403);
        $this->assertEquals('laravel', $thread->fresh()->title);

        $thread = $this->createThread();
        $newUser = $this->actAsUser();
        $this->patchJson(route('threads.update', $thread->id), [
            'best_answer_id' => 1,
        ])->assertStatus(403);

        $this->assertEquals(null, $thread->fresh()->best_answer_id);
    }

    public function test_thread_updating_should_be_validated()
    {
        $thread = $this->createThread();
        $this->patchJson(route('threads.update', $thread->id), [])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_can_delete_own_thread()
    {
        $this->actAsUser();
        $thread = $this->createThread();
        $this->actAsUser();
        $thread->user_id = auth()->id();
        $thread->save();
        $this->deleteJson(route('threads.destroy', $thread->id))->assertStatus(200);

        $this->assertEquals(0, Thread::count());
    }

    public function test_user_can_not_delete_other_users_thread()
    {
        $user2 = $this->actAsUser();
        $thread = $this->createThread();
        $user2 = $this->actAsUser();
        $this->deleteJson(route('threads.destroy', $thread->id))->assertStatus(403);
        $this->assertEquals(1, Thread::count());
    }

    public function actAsUser()
    {
        sanctum::actingAs(User::factory()->create());
        $this->seed(RolePermissionsTableSeeder::class);
    }

    public function createChannel()
    {
        return Channel::factory()->create();

    }

    public function createThread()
    {
        $this->actAsUser();
        return Thread::create([
            'title' => 'laravel',
            'slug' => 'laravel',
            'content' => 'how learn laravel ?',
            'user_id' => auth()->id(),
            'channel_id' => $this->createChannel()->id
        ]);
    }
}
