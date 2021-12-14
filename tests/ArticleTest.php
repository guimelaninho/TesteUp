<?php

use App\Models\Article;
use App\Models\Author;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ArticleTest extends TestCase
{
    //testes básicos
    public function test_index()
    {
        $response = $this->call('GET', '/api/V1/article');

        $this->assertEquals(200, $response->status());
    }

    public function test_insert()
    {
        $this->post('/api/V1/article', [
            'title' => 'Teste',
            'sub_title' => 'teste',
            'description' => 'desct_test',
            'slug' => 'new-test',
            'is_active' => 1,
            'author_id' => Author::create(['name' => 'test_name'])->id
        ])
            ->seeJsonEquals([
                'success' => true,
            ]);
    }


    public function test_update_ok()
    {

        $article = Article::create([
            'title' => 'Teste',
            'sub_title' => 'teste',
            'description' => 'desct_test',
            'slug' => 'new-test',
            'is_active' => 1,
            'author_id' => Author::create(['name' => 'test_name'])->id
        ]);

        $response = $this->call('PUT', '/api/V1/article/' . $article->id, [
            'id' => $article->id,
            'title' => 'Teste',
            'sub_title' => 'teste',
            'description' => 'desct_test',
            'slug' => 'new-test',
            'is_active' => 1,
            'author_id' => Author::create(['name' => 'test_name'])->id
        ]);


        $this->assertEquals(204, $response->status());
    }

    public function test_show_ok()
    {

        $article = Article::create([
            'title' => 'Teste',
            'sub_title' => 'teste',
            'description' => 'desct_test',
            'slug' => 'new-test',
            'is_active' => 1,
            'author_id' => Author::create(['name' => 'test_name'])->id
        ]);
        $response = $this->call('GET', '/api/V1/article/' . $article->id);

        $this->assertEquals(200, $response->status());
    }

    public function test_edit()
    {
        $article = Article::create([
            'title' => 'Teste',
            'sub_title' => 'teste',
            'description' => 'desct_test',
            'slug' => 'new-test',
            'is_active' => 1,
            'author_id' => Author::create(['name' => 'test_name'])->id
        ]);
        $response = $this->call('GET', '/api/V1/article/' . $article->id);

        $this->assertEquals(200, $response->status());
    }

    public function test_delete()
    {

        $article = Article::create([
            'title' => 'Teste',
            'sub_title' => 'teste',
            'description' => 'desct_test',
            'slug' => 'new-test',
            'is_active' => 1,
            'author_id' => Author::create(['name' => 'test_name'])->id
        ]);
        $response = $this->call('delete', '/api/V1/article/' . $article->id);

        $this->assertEquals(200, $response->status());
    }
}
