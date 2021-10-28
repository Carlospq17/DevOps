<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;

class UserTest extends TestCase
{
    private $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    
    public function test_send_valid_token_on_correct_credentials(){
        $current_user = $this->user;

        $this->json('POST', route('user.login'),[
            'email' => $current_user->email,
            'password' => 'root'
        ])->assertStatus(400)->assertJsonStructure(
            [
                'access_token',
                'token_type',
                'expirse_in'
            ]
        );
    }

    public function test_get_auth_user_data(){
        $token = JWTAuth::fromUser($this->user);

        $this->json('GET', route('user.me'), [], ['Authorization'=> 'Bearer ' . $token])
        ->assertStatus(400)
        ->assertJsonStructure(
            [
                'id',
                'email',
                'status',
                'created_at',
                'updated_at'
            ]
        );
    }
}
