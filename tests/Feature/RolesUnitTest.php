<?php

namespace Tests\Feature;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Modules\Roles\Models\Role;
class RolesUnitTest extends TestCase
{

    /**
     * Test the index method.
     *
     * @return void
     */
    public function test_index()
    {
        
        $response = $this->withoutMiddleware()->get('/api/v1/roles');
        $response->assertStatus(200);

        $response->assertJson([
            "status" => true,
            "message" => "Lists of Roles"
        ]);

        dd($response->json());
    }


    public function test_index_with_search()
    {
        $response = $this->get('/api/v1/roles?search=Admin');

        $response->assertStatus(200);
        $response->assertJson([
            "status" => true,
            "message" => "Lists of Roles"
        ]);

        dd($response->json());    
}


    public function test_store()
    {
        $data = [
            'name' => 'Test Role 45',
            'guard_name' => 'web',
        ];

        $response = $this->postJson('/api/v1/roles', $data);
        $response->assertStatus(201);
    
        $this->assertDatabaseHas('roles', [
            'name' => 'Test Role 4',
            'guard_name' => 'web',
        ]);         
        dd($response->getContent());
    }

    public function test_show(){
        $roleID = 1;
        $response = $this->get("/api/v1/roles/{$roleID}");        
        $response->assertStatus(200);

        dd($response->getContent());
    }


    public function test_update()
    {
        $data = [
            'name' => 'Test Updated Role 23',
        ];
        $roleID = 4;

        $response = $this->putJson("/api/v1/roles/{$roleID}", $data);
        // $response->assertStatus(200);
    
        // $this->assertDatabaseHas('roles', [
        //     'name' => 'Test Updated Role',
        //     'guard_name' => 'api',
        // ]);
        dd($response->getContent());
    }


    public function test_destroy()
    {

        $roleID = 3;
        $response = $this->deleteJson("/api/v1/roles/{$roleID}");
        
        $response->assertStatus(204);
        $response->assertSee('');

 
    }
}
