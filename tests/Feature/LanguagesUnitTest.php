<?php

namespace Tests\Feature;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Modules\Languages\Models\Language;
use App\Models\User;
use Illuminate\Http\Request;


class LanguagesUnitTest extends TestCase
{

    /**
     * Test the index method.
     *
     * @return void
     */
    public function test_index()
    {
        
        $response = $this->withoutMiddleware()->get('/api/v1/languages');
        $response->assertStatus(200);

        $response->assertJson([
            "status" => true,
            "message" => "Lists of Languages"
        ]);

        dd($response->json());
    }


    public function test_index_with_search()
    {
        $response = $this->get('/api/v1/languages?search=Python');

        $response->assertStatus(200);
        $response->assertJson([
            "status" => true,
            "message" => "Lists of Languages"
        ]);

        dd($response->json());    
}


    public function test_store()
    {
        $data = [
            'name' => 'Test Language 1',
            'code' => '1001',
            'created_by' => 1
        ];
        $response = $this->postJson('/api/v1/languages', $data, [ "id" => 1]);

       
        // $response->assertStatus(201);
    
        // $this->assertDatabaseHas('languages', [
        //     'name' => 'Test Language',
        //     'code' => '1000',
        //     'created_by' => 1,
        // ]);         
        dd($response->json());
    }

    public function test_show(){
        $languageID = 1;
        $response = $this->get("/api/v1/languages/{$languageID}");        
       //  $response->assertStatus(200);

        dd($response->json());
    }


    public function test_update()
    {
        $data = [
            'name' => 'Test Updated Language 2',
            'code' => '1002',
            'created_by' => 1
        ];
        $languageID = 1;

        $response = $this->putJson("/api/v1/languages/{$languageID}", $data);
        $response->assertStatus(200);
    
        $this->assertDatabaseHas('languages', [
            'name' => 'Test Updated Language',
            'guard_name' => 'api',
        ]);
        // dd($response->json());
    }


    public function test_destroy()
    {

        $languageID = 2;
        $response = $this->deleteJson("/api/v1/languages/{$languageID}");
        
        // $response->assertStatus(204);
        // $response->assertSee('');
        dd($response->json());

 
    }
}
