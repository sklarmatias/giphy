<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User as User;
use App\Models\Favorite as Favorite;
use GuzzleHttp\Client;

class UserController extends Controller
{
    public function query(Request $request) {
        if (!$request->has("q")) {
            return response(["message" => "Bad Request"], 400);
        }
        $q = $request->input("q");
        $limit = ($request->has("limit")) ? $request->input("limit") : env("GIPHY_DEFAULT_LIMIT");
        $offset = ($request->has("offset")) ? $request->input("offset") : env("GIPHY_DEFAULT_OFFSET");

        $api_key = env("GIPHY_API_KEY");
        $url = env("GIPHY_API_URL_SEARCH");

        $client = new \GuzzleHttp\Client();
        $response = $client->request("GET", $url, ["query" => [
            "api_key" => $api_key,
            "q" => $q,
            "limit" => $limit,
            "offset" => $offset,
        ]]);
        $statusCode = $response->getStatusCode();
        $stream = $response->getBody();
        $body = json_decode($stream->getContents());
        return response($body->data, $statusCode);
    }

    function getGifById(Request $request) {
        if (!$request->has("id")) {
            return response(["message" => "Bad Request"], 400);
        }
        $id = $request->input("id");
        $api_key = env("GIPHY_API_KEY");
        $url = env("GIPHY_API_URL_BYID") . $id;

        $client = new \GuzzleHttp\Client();
        $response = $client->request("GET", $url, ["query" => [
            "api_key" => $api_key,
        ]]);
        $statusCode = $response->getStatusCode();
        $stream = $response->getBody();
        $body = json_decode($stream->getContents());
        return response(json_encode($body->data), $statusCode);
    }

    function saveAsFavorite(Request $request) {
        if (!$request->has("gif_id") or !$request->has("alias") or !$request->has('user_id')) {
            return response(["message" => "Bad Request"], 400);
        }
        $user = new User;
        $user_data = $user->where('id', $request->input('user_id'));
        if($user_data->count() == 0) {
            return response(["message" => "Bad Request"], 400);
        }
        $favorite = new Favorite;
        $favorite_data = $favorite->where('uid', $request->input('user_id'))
                                  ->where('gid', $request->input('gif_id'))
                                  ->where('alias', $request->input('alias'));
        if($favorite_data->count() == 0) {
            $favorite->uid = $request->input('user_id');
            $favorite->gid = $request->input('gif_id');
            $favorite->alias = $request->input('alias');
            if ($favorite->save()) {
                return response(["message" => ""], 200);
            }
        } else {
            return response(["message" => ""], 200);
        }
        return response(["message" => "Internal Server Error"], 500);
    }
}
