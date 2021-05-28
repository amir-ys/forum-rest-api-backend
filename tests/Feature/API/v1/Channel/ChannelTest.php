<?php

namespace Tests\Feature\API\v1\Channel;

use App\Models\Channel;
use App\Models\Permission;
use App\Models\User;
use Database\Seeders\RolePermissionsTableSeeder;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ChannelTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_channel_list_should_be_accessible()
    {
        $this->getJson(route('channels.all'))->assertStatus(Response::HTTP_OK);
    }

    public function test_channel_creating_should_be_validated()
    {
        $this->actingAsAdmin();
        $this->postJson(route('channels.store'), [])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_permitted_user_can_store_channel()
    {
        $this->withoutExceptionHandling();
        $this->actingAsAdmin();
        $this->postJson(route('channels.store'),
            ['name' => 'laravel'])->assertStatus(Response::HTTP_CREATED);
    }

    public function test_not_permitted_user_can_not_store_channel()
    {
        $this->actingAsUser();
        $this->postJson(route('channels.store'), ['name' => 'laravel'])
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function test_channel_updating_should_be_validated()
    {
        $this->actingAsAdmin();
        $this->patchJson(route('channels.update'), [])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

    }

    public function test_permitted_user_can_update_channel()
    {
        $this->actingAsAdmin();
        $channel = Channel::factory()->create(['name' => 'laravel']);
        $this->patchJson(route('channels.update'), [
            'id' => $channel->id,
            'name' => 'VueJs'
        ])->assertStatus(Response::HTTP_OK);

        $this->assertEquals('VueJs', $channel->fresh()->name);
    }

    public function test_not_permitted_user_can_not_update_channel()
    {
        $this->actingAsUser();
        $channel = Channel::factory()->create(['name' => 'laravel']);
        $this->patchJson(route('channels.update'), [
            'id' => $channel->id,
            'name' => 'VueJs'
        ])->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertEquals($channel->name, $channel->fresh()->name);
    }

    public function test_channel_deleting_should_be_validated()
    {
        $this->actingAsAdmin();
        $this->deleteJson(route('channels.destroy'), [])
            ->assertStatus(422);

    }

    public function test_permitted_user_can_delete_channel()
    {
        $this->actingAsAdmin();
        $channel = Channel::factory()->create(['name' => 'laravel']);
        $this->deleteJson(route('channels.destroy'), ['id' => $channel->id])
            ->assertStatus(Response::HTTP_OK);
        self::assertEquals(0, Channel::all()->count());
    }

    public function test_not_permitted_user_can_not_delete_channel()
    {
        $this->actingAsUser();
        $channel = Channel::factory()->create(['name' => 'laravel']);
        $this->deleteJson(route('channels.destroy'), ['id' => $channel->id])
            ->assertStatus(Response::HTTP_FORBIDDEN);
        self::assertEquals(1, Channel::all()->count());
    }


    public function actingAsAdmin()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);
        $this->seed(RolePermissionsTableSeeder::class);
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_CHANNELS);
    }

    public function actingAsUser()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);
        $this->seed(RolePermissionsTableSeeder::class);
    }

}
