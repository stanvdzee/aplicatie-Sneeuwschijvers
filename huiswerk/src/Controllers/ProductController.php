<?php

declare(strict_types=1);

namespace App\Controllers;

use GuzzleHttp\Psr7\Utils;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7\ServerRequestInterface;

class HomeController
{
    public function index(): ResponseInterface
    {
        $stream = Utils::streamFor("Homepage");

        $response = new Response();

        $response = $response->withBody($stream);
 
        return $response;
    }

    public function showfunction(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $id = $args['id'];

        $stream = Utils::streamFor("Single product with ID $id");

        $response = new Response();

        $response = $response->withBody($stream);

        return $response;
    }
}