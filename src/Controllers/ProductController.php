<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Entities\Weg;
use Doctrine\ORM\EntityManagerInterface;
use Framework\Controller\AbstractController;
use PDO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
class ProductController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em)
    {

    }

    public function index(): ResponseInterface
    {

        $repo = $this->em->getRepository(Weg::class);

        $products = $repo->findAll();

        return $this->render("product/index", [
            'products' => $products
        ]);

    }
    public function show(ServerRequestInterface $request,array $args): ResponseInterface
    {
        $product = $this->em->find(Weg::class, $args["id"]);

        return $this->render("product/show", [
            "product" => $product
        ]);

    }

    public function create(ServerRequestInterface $request): ResponseInterface
    {
        if ($request->getMethod() === "POST") {

            $parameters = $request->getParsedBody();

            $product = new Weg;

            $product->setName($parameters["name"]);
            $product->setDescription($parameters["description"]);
            $product->setSize(($parameters["size"]));
            $product->setLocation($parameters["location"]);

            $this->em->persist($product);

            $this->em->flush();

            return $this->redirect("/product/{$product->getId()}");
        }

        return $this->render("product/new");
    }
}
