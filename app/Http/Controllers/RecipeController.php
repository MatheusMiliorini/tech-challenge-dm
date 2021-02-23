<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class RecipeController extends Controller {

    /**
     * Busca receitas com base nos ingredientes informados
     */
    public function list (Request $req) {
        $validator = Validator::make($req->all(), [
            'i' => 'required|string|min:1',
            'p' => 'integer|min:1' // Pode estar ausente, mas se informado deve ser numérico
        ], [
            'min' => ':attribute must be greater than or equal to :min',
            'required' => 'You must inform :attribute',
        ]);

        // Valida se os ingredientes foram informados
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->messages()->first()
            ], 400);
        }

        if (!$this->validIngredientsQuery($req['i'])) {
            return response()->json([
                'error' => 'Wrong ingredients format. Must be a string separated by commas.'
            ], 400);
        }

        $sortedIngredients = $this->sortIngredients($req['i']);

        try {
            $jsonResponse = $this->fetchRecipesAsJson($sortedIngredients, ($req['p'] ?? 1));
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error has occured while fetching the recipes. Please, try again.'
            ]);
        }

        $formattedJsonResponse = $this->formatJsonResponse($sortedIngredients, $jsonResponse);
        return response()->json($formattedJsonResponse);
    }

    /**
     * Verifica se o padrão da query de ingredientes está correto
     * @param string $i Lista de ingredientes
     * @return bool
     */
    private function validIngredientsQuery (string $i) : bool {
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

    /**
     * Busca as receitas da API e retorna como JSON
     * @param array $ingredients
     * @param int $p Página da consulta
     */
    private function fetchRecipesAsJson (array $ingredients, int $p) {
        // Busca os dados da API
        $response = Http::get('http://www.recipepuppy.com/api', [
            'i' => implode(',', $ingredients),
            'p' => $p
        ]);
        return $response->json();
    }

    /**
     * Ajusta o formato da resposta da API Recipe Puppy para o formato desejado no teste
     * @param array $ingredients Lista de ingredientes
     * @param array $response Retorno da chamada da API
     * @return array
     */
    private function formatJsonResponse (array $ingredients, array $response) : array {
        $finalResponse = [
            'keywords' => $ingredients,
            'recipes' => []
        ];
        foreach ($response['results'] as $recipe) {
            $finalResponse['recipes'][] = [
                'title'       => $recipe['title'],
                'ingredients' => $this->sortIngredients($recipe['ingredients']),
                'link'        => $recipe['href'],
                'gif'         => $this->findGif($recipe['title'])
            ];
        }
        return $finalResponse;
    }

    /**
     * Busca um gif para a receita
     */
    private function findGif (string $title) : string {
        try {
            $response = Http::get('http://api.giphy.com/v1/gifs/search', [
                'q'       => $title,
                'limit'   => 1,
                'rating'  => 'g', // Better safe than sorry
                'api_key' => config('app.giphy_key'),
            ]);
            $jsonResponse = $response->json();
            // Utilizado downsizedMedium para evitar que o GIF seja muito pesado
            $downsizedMedium = $jsonResponse['data'][0]['images']['downsized_medium'];
            return $downsizedMedium['url'];
        } catch (Exception $e) {
            return '';
        }
    }
}
