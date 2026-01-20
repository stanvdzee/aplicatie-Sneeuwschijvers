<?php 



declare(strict_types=1);

use GuzzleHttp\Psr7\ServerRequest;
use HttpSoft\HttpEmitter\SapiEmitter;
use League\Route\Router;
use App\Controllers\HomeController;
use App\Controllers\ProductController;

ini_set('display_errors', '1');

require dirname(__DIR__) . '/vendor/autoload.php';

$request = ServerRequest::fromGlobals();

$route = new Router;

$router->get("/", [HomeController::class, "index"]);

$router->get("/products", [ProductController::class, "index"]);

$request = ServerRequest::fromGlobals();

$router->get("/product/{id:number}",[ProductController::class, "show"]);   
$response = new Response();

$response = $router->dispatch($request);
$response = $response->withStatus(418) 
                        ->withHeader("X-Powered-By", "PHP")
                        ->withBody($stream);

$emitter = new SapiEmitter();
?>