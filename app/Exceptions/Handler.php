<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

use function PHPSTORM_META\type;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        $debug = config('app.debug');

        $rendered = parent::render($request, $exception);

        if ($exception instanceof NotFoundHttpException) {
            return $this->renderExceptionToJson($rendered, 'URL_NOT_FOUND');
        } else if ($exception instanceof MethodNotAllowedHttpException) {
            return $this->renderExceptionToJson($rendered, 'METHOD_NOT_ALLOWED');
        } else if ($exception instanceof ValidationException) {
            $dados = json_decode($rendered->getContent(), JSON_OBJECT_AS_ARRAY);
            return $this->renderExceptionToJson($rendered, 'VALIDATION', $dados);
        } else if ($exception instanceof ModelNotFoundException) {
            return $this->renderExceptionToJson($rendered, 'ENTITY_NOT_FOUND');
        } else {
            return $this->renderExceptionToJson($rendered, $exception->getMessage());
        }
    }

    /**
     *  @OA\Schema(
     *     schema="Erro",
     *     type="object",
     *     title="Erro",
     *     description="Erro inesperado pelo servidor",
     *     properties={      
     *         @OA\Property(property="code", type="integer"),
     *         @OA\Property(property="message", type="string")
     *     }
     *  )
     */
    protected function criaArrayErros(string $codigo, string $mensagem, array $dados = [])
    {
        $retorno = ['codigo' => $codigo, 'mensagem' => $mensagem];

        if (!empty($dados)) {
            $retorno['dados'] = $dados;
        }

        return $retorno;
    }

    protected function renderExceptionToJson($rendered, $message, array $data = [])
    {
        $code = $rendered->getStatusCode();
        $errorArray = $this->criaArrayErros($code, $message, $data);

        return response()->json($errorArray, $code);
    }
}
