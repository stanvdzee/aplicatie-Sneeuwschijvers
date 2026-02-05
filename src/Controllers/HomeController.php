<?php

declare(strict_types=1);

namespace App\Controllers;

use http\Encoding\Stream;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;

class HomeController
{
    public function __construct( private ResponseFactoryInterface $factory){

    }
    public function index(): ResponseInterface
    {
        $object = '<pre>' . print_r(file_get_contents("https://weerlive.nl/api/weerlive_api_v2.php?key=ff1308b93f&locatie=sneek"),true) . '</pre>';

        $stream = $this->factory->createStream($object);

        $response = $this->factory->createResponse(200);

        $response = $response->withBody($stream);

        return $response;
    }
}