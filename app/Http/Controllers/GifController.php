<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class GifController extends Controller
{

    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @OA\Get(
     * path="/api/v1/gifs",
     * summary="Buscar GIFs en Giphy API",
     * tags={"Giphy Endpoints"},
     * security={{"bearerAuth": {}}},
     * @OA\Parameter(name="q", in="query", description="Palabra clave", required=true, @OA\Schema(type="string", example="matrix")),
     * @OA\Parameter(name="limit", in="query", description="Límite", required=false, @OA\Schema(type="integer", example=25)),
     * @OA\Parameter(name="offset", in="query", description="Desplazamiento", required=false, @OA\Schema(type="integer", example=0)),
     * @OA\Response(response=200, description="Listado de GIFs devuelto exitosamente"),
     * @OA\Response(response=400, description="Falta el parámetro 'q'")
     * )
     */
    public function query(Request $request) {
        if (!$request->has("q")) {
            return response(["message" => "Bad Request"], 400);
        }
        
        $q = $request->input("q");
        $limit = $request->input("limit", env("GIPHY_DEFAULT_LIMIT", 25));
        $offset = $request->input("offset", env("GIPHY_DEFAULT_OFFSET", 0));

        $api_key = env("GIPHY_API_KEY");
        $url = env("GIPHY_API_URL_SEARCH");

        $response = $this->client->request("GET", $url, ["query" => [
            "api_key" => $api_key,
            "q" => $q,
            "limit" => $limit,
            "offset" => $offset,
        ]]);
        
        $body = json_decode($response->getBody()->getContents());
        return response()->json($body->data, $response->getStatusCode());
    }

    /**
     * @OA\Get(
     * path="/api/v1/gifs/{id}",
     * summary="Obtener un GIF específico por su ID",
     * tags={"Giphy Endpoints"},
     * security={{"bearerAuth": {}}},
     * @OA\Parameter(name="id", in="path", description="ID único del GIF", required=true, @OA\Schema(type="string", example="3rVme9JE8xrlW")),
     * @OA\Response(response=200, description="Estructura de datos del GIF"),
     * @OA\Response(response=400, description="ID inválido")
     * )
     */
    public function getGifById(Request $request, $id) {
        if (empty($id)) {
            return response(["message" => "Bad Request"], 400);
        }
        
        $api_key = env("GIPHY_API_KEY");
        $url = env("GIPHY_API_URL_BYID") . $id;

        $response = $this->client->request("GET", $url, ["query" => [
            "api_key" => $api_key,
        ]]);
        
        $body = json_decode($response->getBody()->getContents());
        return response()->json($body->data, $response->getStatusCode());    
    }
}
