<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GifIntegrationTest extends TestCase
{
    use RefreshDatabase; // Resetea la base de datos en memoria para cada test

    protected function setUp(): void
    {
        parent::setUp();
        
        // Creamos un usuario de prueba en la DB local simulada
        $user = User::factory()->create();
        
        // Actuamos como ese usuario autenticado mediante Passport para pasar el middleware auth:api
        Passport::actingAs($user);
    }

    /**
     * Testear que la búsqueda de GIFs funciona correctamente mockeando la API externa.
     */
    public function test_gifs_search_returns_successful_data(): void
    {
        // 1. Creamos un "Mock" de la respuesta que devolvería Giphy en condiciones normales
        $mockResponseBody = json_encode([
            'data' => [
                ['id' => '3rVme9JE8xrlW', 'title' => 'Robot Matrix GIF', 'url' => 'https://giphy.com/...']
            ]
        ]);

        $mockHandler = new MockHandler([
            new Response(200, [], $mockResponseBody)
        ]);

        $handlerStack = HandlerStack::create($mockHandler);

        // 2. Registramos el Binding en el contenedor de Laravel.
        // Cada vez que el controlador pida un Client, Laravel va a ejecutar esta función
        // inyectándole el stack con nuestro handler falso.
        $this->app->bind(Client::class, function () use ($handlerStack) {
            return new Client(['handler' => $handlerStack]);
        });

        // 3. Ejecutamos la petición HTTP simulada a nuestra propia API ruteada
        $response = $this->getJson('/api/v1/gifs?q=robot&limit=1');

        // 4. Asersiones (Validaciones de que todo salió como esperábamos)
        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment(['id' => '3rVme9JE8xrlW']);
    }

    /**
     * Testear que si falta el parámetro 'q', la API responde con un Bad Request (400).
     */
    public function test_gifs_search_without_query_returns_bad_request(): void
    {
        // Enviamos la petición sin el parámetro '?q='
        $response = $this->getJson('/api/v1/gifs');

        // Validamos que el controlador frene la petición con un 400
        $response->assertStatus(400);
        $response->assertJson(['message' => 'Bad Request']);
    }
}
