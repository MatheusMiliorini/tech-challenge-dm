<?php

namespace App\Classes;

use Illuminate\Support\Facades\Http;

class Giphy {

    /**
     * Retorna o primeiro gif encontrado com base na pesquisa
     */
    public function firstGif (string $search) : string {
        try {
            $response = Http::get('http://api.giphy.com/v1/gifs/search', [
                'q'       => $search,
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