<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Favorite;

class UserController extends Controller
{
    /**
     * @OA\Post(
     * path="/api/v1/gifs/favorites",
     * summary="Guardar un GIF en los favoritos del usuario",
     * tags={"Giphy Endpoints"},
     * security={{"bearerAuth": {}}},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * required={"gif_id","alias","user_id"},
     * @OA\Property(property="gif_id", type="string", example="3rVme9JE8xrlW"),
     * @OA\Property(property="alias", type="string", example="Mi favorito"),
     * @OA\Property(property="user_id", type="integer", example=1)
     * )
     * ),
     * @OA\Response(response=200, description="Guardado exitoso o ya existente"),
     * @OA\Response(response=400, description="Error en los parámetros de entrada")
     * )
     */
    public function saveAsFavorite(Request $request) {
        if (!$request->has(["gif_id", "alias", "user_id"])) {
            return response(["message" => "Bad Request"], 400);
        }

        if (!User::where('id', $request->input('user_id'))->exists()) {
            return response(["message" => "User not found"], 400);
        }

        // Evitar duplicados semánticos
        $favorite = Favorite::firstOrCreate([
            'uid'   => $request->input('user_id'),
            'gid'   => $request->input('gif_id'),
            'alias' => $request->input('alias')
        ]);

        return response(["message" => "Favorite processed successfully"], 200);
    }
}
