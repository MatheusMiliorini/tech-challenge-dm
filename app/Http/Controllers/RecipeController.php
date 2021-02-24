<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use App\Classes\RecipePuppy;
use App\Classes\InvalidIngredientsListException;

class RecipeController extends Controller {

    /**
     * Essa função é apenas auxiliar para criar a lista de ingredientes que irá no front-end
     * Não encontrei na documentação do Recipe Puppy uma lista de ingredientes, então debuguei as requests do site para chegar nesse resultado
     */
    public function getIngredients () {
        $ingredients = [];
        for ($i = 1; $i < 21; $i++) {
            $response = Http::get("http://www.recipepuppy.com/api/?p=$i");
            $json = $response->json();
            foreach ($json['results'] as $r) {
                $_ingredients = explode(', ', $r['ingredients']);
                foreach ($_ingredients as $ing) {
                    $ingredients[] = $ing;
                }
            }
        }
        $uniques = array_values(array_unique($ingredients));
        sort($uniques);
        return response($uniques);
    }

    /**
     * Busca receitas com base nos ingredientes informados
     */
    public function list (Request $req) {
        $validator = Validator::make($req->all(), [
            'i' => 'required|string|min:1',
            'p' => 'integer|min:1' // Pode estar ausente, mas se informado deve ser numérico
        ], [
            'min'      => ':attribute must be greater than or equal to :min',
            'required' => 'You must inform :attribute',
        ]);

        // Valida se os ingredientes foram informados
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->messages()->first()
            ], 400);
        }

        try {
            $recipePuppy = new RecipePuppy($req['i'], $req['p'] ?? 1);
            return response()->json($recipePuppy->fetchRecipes());
        } catch (InvalidIngredientsListException $e) {
            return response()->json([
                'error' => 'Wrong ingredients format. Must be a string separated by commas.'
            ], 400);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error has occured while fetching the recipes. Please, try again.'
            ], 500);
        }
    }
}
