<?php

declare(strict_types=1);

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMSetup;
use Dotenv\Dotenv;
use Framework\Template\RendererInterface;
use HttpSoft\Emitter\SapiEmitter;
use League\Route\Router;
use App\Controllers\HomeController;
use App\Controllers\ProductController;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseFactoryInterface;
use GuzzleHttp\Psr7\HttpFactory;
use League\Route\Strategy\ApplicationStrategy;
use Framework\Template\Renderer;
use Framework\Template\PlatesRenderer;

ini_set('display_errors', 1);

define("APP_ROOT", dirname(__DIR__));

require APP_ROOT . '/vendor/autoload.php';

$request = ServerRequest::fromGlobals();

$dotenv = Dotenv::createImmutable(APP_ROOT);
$dotenv->load();

$builder = new DI\ContainerBuilder();

$builder->addDefinitions(APP_ROOT . "/config/container.php");

$builder->useAttributes(true);

$container = $builder->build();

$router = new Router;

$strategy = new ApplicationStrategy;
$strategy->setContainer($container);
$router->setStrategy($strategy);

$routes = require dirname(APP_ROOT . "/config/routes.php");
$routes($router);

$response = $router->dispatch($request);

$emitter = new SapiEmitter;

$emitter->emit($response);