<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Http\Response as status;
use Illuminate\Support\Facades\Hash;

class TestUsuario extends TestCase
{
    use RefreshDatabase;

    protected static $urls;
   
    protected $data;

    public static function setUpBeforeClass(): void{
        parent::setUpBeforeClass();
        self::$urls = '/api';
        //self::$users = User::factory()->count(10)->create();
    }

    public function setUp():void{
        parent::setUp();
        $this->artisan('migrate');
        $this->data = User::factory()->count(10)->create([
            'password' => 'password',
        ]);
        
    }

    public function test_register(){
        $this->data = [
            'name' => 'Juan Perez',
            'email' => 'newuser@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->postJson(self::$urls.'/register', $this->data);

        $response->assertStatus(status::HTTP_CREATED);

        $responseData = $response->json();

        $this->assertDatabaseHas('users', [
            'name' => $this->data['name'],
            'email' => $this->data['email'],
        ]);

        $this->assertEquals($responseData['user']['name'], $this->data['name']);

    }

    public function test_login(){
        $user = User::factory()->create();

        $response = $this->post(self::$urls.'/login', [
            'email' => $user->email,
            'password' => 'password' 
        ]);

        $response->assertStatus(status::HTTP_OK); 
    }

    public function test_list(){

        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $response = $this->post(self::$urls.'/login', [
            'email' => $user->email,
            'password' => 'password' 
        ]);

        $response->assertStatus(status::HTTP_OK); 

        $response->assertJsonStructure(['token']);

        $token = $response->json('token');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ]) ->getJson(self::$urls.'/list');

        $response->assertStatus(status::HTTP_OK);

        //print_r(">>>>>".count($this->data));

        $this->assertCount(count($this->data), $response->json());
    }

    public function  test_retrive() {

        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $response = $this->post(self::$urls.'/login', [
            'email' => $user->email,
            'password' => 'password' 
        ]);

        $response->assertStatus(status::HTTP_OK); 

        $response->assertJsonStructure(['token']);

        $token = $response->json('token');

        $user = User::factory()->create();

        //print_r($user);

        $updateData = [
            'name' => 'Juan Pérez',
            'email' => 'juanperez@example.com',
            'password' => 'nuevacontraseña',
            'password_confirmation' => 'nuevacontraseña',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->patchJson(self::$urls."/users/{$user->id}", $updateData);

        $response->assertStatus(status::HTTP_OK);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Juan Pérez',
            'email' => 'juanperez@example.com',

        ]);

        //print_r($response->json());
    }

    public function test_delete(){

        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $response = $this->post(self::$urls.'/login', [
            'email' => $user->email,
            'password' => 'password' 
        ]);

        $response->assertStatus(status::HTTP_OK); 

        $response->assertJsonStructure(['token']);

        $token = $response->json('token');

        $user = User::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->deleteJson(self::$urls."/users/{$user->id}");

        $this->assertDatabaseMissing("users", ['id' => $user->id]);

        $response->assertStatus(status::HTTP_OK);
    }
}

