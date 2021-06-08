<?php

namespace Tests\Feature\API\v1\Thread;

use App\Models\Answer;
use App\Models\Channel;
use App\Models\Permission;
use App\Models\Thread;
use App\Models\User;
use Database\Seeders\RolePermissionsTableSeeder;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AnswerTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_answers_should_be_accessible()
    {
        $this->getJson(route('answers.index'))->assertStatus(Response::HTTP_OK);
    }

    public function test_create_new_answers_should_be_validated()
    {
        $this->actAsUser();
        $response = $this->postJson(route('answers.store'), []);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['content', 'thread_id', 'user_id']);

    }

    public function test_user_can_submit_answers_to_thread()
    {
        $this->actAsUser();
        $thread = $this->createThread();
        $this->postJson(route('answers.store'), [
            'content' => 'answers for this threads',
            'thread_id' => $thread->id,
            'user_id' => auth()->id(),
        ])->assertCreated();
        $this->assertEquals(1, Answer::count());
    }

    public function test_update_answers_should_be_validated()
    {
        $this->actAsUser();
        $answer = $this->createAnswer();
        $response = $this->putJson(route('answers.update', $answer->id), []);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['content']);
    }

    public function test_user_can_update_own_answers()
    {
        $this->actAsUser();
        $answer =  Answer::factory()->create([
            'content' => 'laravel' ,
            'user_id' => auth()->id()
        ]);
        $this->patch(route('answers.update', $answer->id), [
            'content' => 'vuejs',
        ])->assertOk();
        $this->assertEquals('vuejs', $answer->fresh()->content);

        $this->actAsUser();
        $answer =  $this->createAnswer();
        $this->patch(route('answers.update', $answer->id), [
            'content' => 'vuejs',
        ])->assertForbidden();
        $this->assertEquals('laravel', $answer->fresh()->content);
    }

    public function test_user_can_delete_own_answers()
    {
        $this->actAsUser();
        $thread = $this->createThread();
        $answer =  Answer::factory()->create([
            'content' => 'laravel' ,
            'user_id' => auth()->id()
        ]);
        $response = $this->deleteJson(route('answers.destroy', $answer->id));
        $response->assertOk();
        $response->assertJson(['message' => 'answer deleted successfully']);
        $this->assertFalse(Thread::find($answer->thread_id)->answers()->whereContent($answer->content)->exists());
        $this->assertEquals(0, Answer::count());

        $this->actAsUser();
        $answer =  $this->createAnswer();
        $response = $this->deleteJson(route('answers.destroy', $answer->id))->assertForbidden();
        $this->assertEquals(1, Answer::count());

    }

    public function test_user_score_will_increase_when_answer_a_thread()
    {
        $this->actAsUser();
        $thread = $this->createThread();
        $this->postJson(route('answers.store') ,  [
            'content' => 'answers for this threads',
            'thread_id' => $thread->id,
            'user_id' => auth()->id(),
        ]);
        $this->assertEquals(10 , auth()->user()->score);
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
