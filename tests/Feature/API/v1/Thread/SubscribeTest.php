<?php

namespace Tests\Feature\API\v1\Thread;

use App\Models\Answer;
use App\Models\Channel;
use App\Models\Subscribe;
use App\Models\Thread;
use App\Models\User;
use App\Notifications\NewReplySubmitted;
use Database\Seeders\RolePermissionsTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SubscribeTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_subscribe_a_thread()
    {
        $this->actAsUser();
        $thread = $this->createThread();
        $response = $this->postJson(route('subscribe', $thread->id));
        $response->assertOk();
        $response->assertJson(['message' => 'thread subscribe successfully']);
        $this->assertEquals($thread->id, Subscribe::where('thread_id', $thread->id)->first()->thread_id);

    }

    public function test_user_can_unsubscribe_a_thread()
    {
        $this->actAsUser();
        $thread = $this->createThread();
        $this->postJson(route('subscribe', $thread->id));

        $response = $this->deleteJson(route('unSubscribe', $thread->id));
        $response->assertOk();
        $response->assertJson(['message' => 'thread unsubscribe successfully']);
        $this->assertEquals(null, Subscribe::where('thread_id', $thread->id)->first());

    }

    public function test_notification_will_send_to_subscribes_of_thread()
    {
        Notification::fake();
        $this->actAsUser();
        $thread = $this->createThread();
        $this->postJson(route('subscribe', $thread->id));
        $this->assertEquals(auth()->id(), (Subscribe::find(1))->user_id);

        $this->postJson(route('answers.store'), [
            'content' => 'Foo',
            'thread_id' => $thread->id,
            'user_id' => auth()->id()
        ]);
        $this->assertEquals('Foo', (Answer::find(1))->content);
        Notification::assertSentTo(auth()->user(), NewReplySubmitted::class);
    }

    private function actAsUser()
    {
        sanctum::actingAs(User::factory()->create());
        $this->seed(RolePermissionsTableSeeder::class);
    }

    private function createChannel()
    {
        return Channel::factory()->create();

    }

    private function createAnswer()
    {
        return Answer::factory()->create([
            'content' => 'laravel'
        ]);
    }

    private function createThread()
    {
        return Thread::create([
            'title' => 'laravel',
            'slug' => 'laravel',
            'content' => 'how learn laravel ?',
            'user_id' => auth()->id(),
            'channel_id' => $this->createChannel()->id
        ]);
    }
}
