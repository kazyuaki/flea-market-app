<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;


class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */

    public function testLoginFailsWhenEmailIsMissing()
    {
        $response = $this->post('/login',[
            'email' => '',
            'password' => 'password123'
        ]);
        $response->assertSessionHasErrors(['email']);
    }

    public function testLoginFailsWhenPasswordIsMissing()
    {
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => ''
        ]);

        $response->assertSessionHasErrors(['password']);
    }

    public function testLoginFailsWithInvalidCredentials()
    {
        $response = $this->post('/login', [
            'email' => 'wrong@example.com',
            'password' => 'invalidpass'
        ]);

        $response->assertSessionHas('error', 'ログイン情報が登録されていません');
    }

    public function testLoginSucceedsWithValidCredentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123')
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123'
        ]);

        $response->assertRedirect('/'); 

        $this->assertAuthenticatedAs($user);
    }
}
