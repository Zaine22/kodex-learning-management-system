<?php

namespace Tests\Feature;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Role;

class RolesPermissionsTest extends TestCase
{

    /**
     * Test the index method.
     *
     * @return void
     */
    public function test_index()
    {
        
        $response = $this->get('/api/v1/roles_permissions');

        $response->assertStatus(200);

        $response->assertJson([
            "status" => true,
            "message" => "Lists of Roles"
        ]);

        $response->assertStatus(200);
        dd($response->getContent());
    }


    public function test_index_with_search()
    {
        $response = $this->get('/api/v1/roles_permissions?search=Admin');

        $response->assertStatus(200);
        $response->assertJson([
            "status" => true,
            "message" => "Lists of Roles"
        ]);

        dd($response->getContent());
    }


    public function test_store()
    {
        $data = [
            'name' => 'Test Role 3',
            'guard_name' => 'web',
        ];

        $response = $this->postJson('/api/v1/roles_permissions', $data);
        $response->assertStatus(200);
    
        $this->assertDatabaseHas('roles', [
            'name' => 'Test Role 4',
            'guard_name' => 'web',
        ]);
    }

    public function test_show(){
        $roleID = 1;
        $response = $this->get("/api/v1/roles_permissions/{$roleID}");        
        $response->assertStatus(200);

        dd($response->getContent());
    }


    public function test_update()
    {
        $data = [
            'name' => 'Test Updated Role',
            'guard_name' => 'api',
        ];
        $roleID = 4;

        $response = $this->putJson("/api/v1/roles_permissions/{$roleID}", $data);
        $response->assertStatus(200);
    
        $this->assertDatabaseHas('roles', [
            'name' => 'Test Updated Role',
            'guard_name' => 'api',
        ]);
    }


    public function test_destroy()
    {
        $role = Role::create([
            'name' => 'Testing 1',
            'guard_name' => 'api',
        ]);

        $roleID = $role->id;

        $response = $this->deleteJson("/api/v1/roles_permissions/{$roleID}");
        $response->assertStatus(200);

        $response->assertJson([
            "status" => true,
            "data"    => null,
            "message" => "Role deleted successfully",
        ]);

        $this->assertDatabaseMissing('roles', [
            'id' => $roleID,
        ]);
    }


}
