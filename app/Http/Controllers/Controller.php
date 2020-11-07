<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * Class Controller
 * @package App\Http\Controllers
 * @OA\OpenApi(
 *     @OA\Info(
 *         version="1.0.0",
 *         title="Documentação API Localização",
 *         @OA\License(name="MIT")
 *     ),
 *     @OA\Server(
 *         description="Servidor API REST",
 *         url="http://localhost:8000/api/",
 *     ),
 * )
 */
class Controller extends BaseController
{
    protected const MENSAGENS = [
        'required' => 'O campo :attribute é obrigatório!',
        'regex' => 'O campo :attribute é obrigatório!',
    ];

    protected function createResponse($content, $status = 200, array $headers = [])
    {
        $contentFormatado = [
            'codigo' => $status,
            'dados' => $content
        ];

        return response($contentFormatado, $status, $headers);
    }
}
