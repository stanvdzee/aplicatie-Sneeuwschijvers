<?php

declare(strict_types=1);

namespace App\Controllers;

use GuzzleHttp\Psr7\Utils;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;

class HomeController
{
    public function index(): Response
    {
        $stream = Utils::streamFor("Homepage");

        $response = new Response();

        $response = $response->withBody($stream);
 
        return $response;
    }

    public function showfunction(ServerRequest $request, array $args): Response
    {
        $id = $args['id'];

        $stream = Utils::streamFor("Single product with ID $id");

        $response = new Response();

        $response = $response->withBody($stream);

        return $response;
    }
}