<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    public function testProfileUpdate()
    {
        $response = $this->post("/user/update", ['forge_token' => 'ham']);
        $response->assertRedirect('/login');

        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->post("/user/update", ['forge_token' => 'ham']);
        $response->assertRedirect('/home');
        $this->assertSame($user->forge_token, 'ham');
    }
}
