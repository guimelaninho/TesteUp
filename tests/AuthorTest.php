<?php

use App\Models\Author;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;

class AuthorTest extends TestCase
{
    //testes básicos

    public function test_index()
    {
        $response = $this->call('GET', '/api/V1/author');

        $this->assertEquals(200, $response->status());
    }

    public function test_insert()
    {
        $this->post('/api/V1/author', ['name' => 'Test'])
            ->seeJsonEquals([
                'success' => true,
            ]);
    }


    public function test_update_ok()
    {

        $author = Author::create([
            'name' => 'name_test'
        ]);

        $response = $this->call('PUT', '/api/V1/author/' . $author->id, [
            'id' => $author->id,
            'name' => 'edited'
        ]);

        $this->assertEquals(204, $response->status());
    }

    public function test_show_ok()
    {

        $author = Author::create([
            'name' => 'name_test'
        ]);
        $response = $this->call('GET', '/api/V1/author/' . $author->id);

        $this->assertEquals(200, $response->status());
    }

    public function test_edit()
    {

        $author = Author::create([
            'name' => 'name_test'
        ]);
        $response = $this->call('GET', '/api/V1/author/' . $author->id);

        $this->assertEquals(200, $response->status());
    }

    public function test_delete()
    {

        $author = Author::create([
            'name' => 'name_test'
        ]);
        $response = $this->call('delete', '/api/V1/author/' . $author->id);

        $this->assertEquals(200, $response->status());
    }
}
