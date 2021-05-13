<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_should_validate()
    {
        $this->postJson(route('register'))->assertStatus(422);
    }

    public function test_new_user_can_register()
    {
        $this->withoutExceptionHandling();
       $response =  $this->postJson(route('register'), [
            'name' => 'amir-ys',
            'email' => 'amiryou74@gmail.com',
            'password' => '12345678',
        ]);

        $response->assertStatus(201);
    }
}
