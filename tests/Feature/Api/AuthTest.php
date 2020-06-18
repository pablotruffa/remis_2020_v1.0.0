<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\RemisUsers;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{   
    use RefreshDatabase;

    protected $user;
    protected $guest;

    public function setUp() :void
    {
        parent::setUp();
        Artisan::call('db:seed');
        $this->user = RemisUsers::first();
    }

    public function test_user_login_returns_token()
    {   

        $response = $this->json('POST','api/login',[
            'email'     => $this->user->email,
            'password'  => 1234,
        ]);

        $response->assertStatus(200);
        $token = json_decode($response->content());
        
        return $token;
    }

    public function test_guest_fails_logging_in_and_gets_error_401()
    {
        $response = $this->json('POST','api/login',[
            'email'     => 'alfonso@gmail.com',
            'password'  => 1234,
        ]);

        $response->assertStatus(401);
        $response->assertJsonFragment([
            'error' =>  'Unauthorized'
        ]);
    }
    
    /**
     * @depends test_user_login_returns_token
     */
    public function test_only_logged_users_can_logout($token)
    {   
        $user = $this->user;
        $response = $this->withHeaders([
            'Authorization' => "$token->token_type $token->access_token"
        ])
        ->json('GET','api/logout');
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'message' => 'Successfully logged out'
        ]);
    }

    public function test_guest_tries_to_logout_without_authentication_and_gets_error_401()
    {
        $response = $this->json('GET','api/logout');
        $response->assertStatus(401);
    }
 
}
