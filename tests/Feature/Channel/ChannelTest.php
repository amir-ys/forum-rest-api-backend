<?php

namespace Tests\Feature\Channel;

use App\Models\Channel;
use Database\Factories\ChannelFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ChannelTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_channel_list_should_be_accessible()
    {
        $this->getJson(route('channels.all'))->assertStatus(200);
    }

    public function test_channel_creating_should_be_validate()
    {
        $this->postJson(route('channels.store'), [])->assertStatus(422);
    }

    public function test_create_new_channel()
    {
        $this->withoutExceptionHandling();
        $this->postJson(route('channels.store'), ['name' => 'laravel'])->assertStatus(201);
    }


}
