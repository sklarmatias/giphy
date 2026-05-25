<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 * version="1.0.0",
 * title="Giphy Integration API Documentation",
 * description="API RESTful para la integración y búsqueda de GIFs protegida por Laravel Passport",
 * @OA\Contact(
 * email="tu-email@ejemplo.com"
 * )
 * )
 *
 * @OA\Server(
 * url="http://localhost:8000",
 * description="Servidor Local de Desarrollo"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
