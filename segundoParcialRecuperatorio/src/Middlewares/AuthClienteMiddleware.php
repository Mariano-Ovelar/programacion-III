<?php

namespace App\Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use \Firebase\JWT\JWT;
use App\MyClass\Token;

// use Psr\Http\Message\ResponseInterface as Response;

class AuthClienteMiddleware
{
    /**
     * Example middleware invokable class
     *
     * @param  ServerRequest  $request PSR-7 request
     * @param  RequestHandler $handler PSR-15 request handler
     *
     * @return Response
     */
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $token = getallheaders()['token'] ?? '';
        $retorno = "";
        $payload = Token::decodificarToken($token);
        if ($payload->tipo == "cliente") {
            $response = $handler->handle($request);
            $existingContent = (string) $response->getBody();
            $resp = new Response();
            //$resp->getBody()->write("TODO OK!!!! <br>");
            $resp->getBody()->write($existingContent);
            $retorno = $resp;
        } else {
            $response = new Response();
            $response->getBody()->write("PROIBIDO EL PASO!!!");
            $retorno = $response->withStatus(403);
        }

        return $retorno;
    }
}
