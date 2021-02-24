<?php

namespace App\Classes;

use Illuminate\Support\Facades\Http;
use App\Classes\Giphy;
use Exception;

class RecipePuppy {
    /** @var string*/
    public $i;
    /** @var int */
    public $p;
    /** @var array */
    public $ingredients;

    /**
     * @param string $i string de ingredientes
     * @param int $p página
     */
    public function __construct(string $i, int $p) {
        $this->i = $i;
        $this->p = $p;
        // Valida a lista de ingredientes
        if (!$this->validIngredientsList($i)) {
            throw new InvalidIngredientsListException();
        }
        // Separa os ingredientes e ordena
        $this->ingredients = $this->sortIngredients($this->i);
    }

    /**
     * Busca as receitas no formato correto
     */
    public function fetchRecipes () : array {
        $recipesJson = $this->fetchAPI();
        return $this->formatAPIResponse($recipesJson);
    }

    /**
     * Busca os dados da API Recipe Puppy e retorna o resultado sem ajustes
     */
    private function fetchAPI () : array {
        // Busca os dados da API
        $response = Http::get('http://www.recipepuppy.com/api', [
            'i' => implode(',', $this->ingredients),
            'p' => $this->p
        ]);

        // Throw apenas se ocorrer um erro na request
        $response->throw();

        return $response->json();
    }

    private function formatAPIResponse (array $apiResponse) {
        $finalResponse = [
            'keywords' => $this->ingredients,
            'recipes' => []
        ];

        $giphy = new Giphy();

        foreach ($apiResponse['results'] as $recipe) {
            $finalResponse['recipes'][] = [
                'title'       => $recipe['title'],
                'ingredients' => $this->sortIngredients($recipe['ingredients']),
                'link'        => $recipe['href'],
                'gif'         => $giphy->firstGif($recipe['title'])
            ];
        }
        return $finalResponse;
    }

    /**
     * Verifica se o padrão da query de ingredientes está correto
     * @param string $i Lista de ingredientes
     * @return bool
     */
    private function validIngredientsList (string $i) : bool {
        return preg_match('/^(?:[a-zA-Z\s],?)+$/', $i) === 1;
    }

    /**
     * Separa os ingredientes e ordena alfabeticamente
     * @param string $i Lista de ingredientes
     * @return array
     */
    private function sortIngredients (string $i) : array {
        $exploded = array_map('trim', explode(',', $i));
        sort($exploded);
        return $exploded;
    }
}

class InvalidIngredientsListException extends \Exception {}

