<?php

namespace Tests\Feature;

use App\Model\UserData\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function should_新しいユーザを作成して返却する()
    {
        $data = [
            'name' => 'vuesplash user',
            'email' => 'dummy@email.com',
            'password' => 'test1234',
        ];

        $response = $this->json('POST', route('register'), $data);
        $user = User::first();
        $response
            ->assertStatus(201)
            ->assertJson(['name' => $user->name]);

        $this->assertEquals($data['name'], $user->name);

    }
}
