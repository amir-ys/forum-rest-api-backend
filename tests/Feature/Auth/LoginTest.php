<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_should_validate()
    {
        $this->postJson(route('login'))->assertStatus(422);
    }

    public function test_user_can_login()
    {
        $user = $this->createUser();
        $this->postJson(route('login'), [
            'email' => $user->email,
            'password' => '12345678',
        ])->assertStatus(200);

        $this->assertAuthenticated();
    }

    public function test_logged_in_user_can_logout()
    {
        $this->actingAs($this->createUser());
        $this->postJson(route('logout'))->assertStatus(200);
    }


    public function test_show_user_info_if_logged_in()
    {
        $this->actingAs($this->createUser());
        $this->postJson(route('user'))->assertStatus(200);
    }

    public function createUser()
    {
        return User::create([
            'name' => 'amir',
            'email' => 'amiryou74@gamil.com',
            'password' => bcrypt('12345678')
        ]);
    }
}
