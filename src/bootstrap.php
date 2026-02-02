<?php 

declare(strict_types=1);

use App\Controllers\ProductController;
use HttpSoft\Emitter\SapiEmitter;
use League\Route\Router;
use App\Controllers\HomeController;

ini_set('display_errors', '1');

require dirname(__DIR__) . '/vendor/autoload.php';

$request = \GuzzleHttp\Psr7\ServerRequest::fromGlobals();

$router = new Router;

$router->get("/", [HomeController::class, "index"]);

$router->get("/products", [ProductController::class, "index"]);

$router->get("/product/{id:number}",[ProductController::class, "show"]);

$response = $router->dispatch($request);

$emitter = new SapiEmitter;

$emitter->emit($response);