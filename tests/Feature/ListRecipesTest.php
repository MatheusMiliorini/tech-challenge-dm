<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ListRecipesTest extends TestCase
{
    /**
     * Testa o endpoint de receitas
     *
     * @return void
     */
    public function testRequest()
    {
        // Ingredientes devem ser informados
        $response = $this->get('/recipes');
        $response->assertStatus(400);
        // O formato dos ingredientes deve estar correto
        $response = $this->get('/recipes?i=onions,gar_lic');
        $response->assertStatus(400);
        // Uma request correta
        $response = $this->get('/recipes?i=onions,garlic');
        $response->assertStatus(200);
        // Garante que o retorno esteja no formato correto
        $response->assertJsonStructure([
            'keywords',
            'recipes' => [
                '*' => [
                    'title',
                    'ingredients',
                    'link',
                    'gif'
                ]
            ]
        ]);
        $this->assertIsArray($response['keywords']);
        $this->assertIsArray($response['recipes']);
    }
}
