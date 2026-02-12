<?php
/**
 * array[Product::class] $products
 */

$this->layout("layout", ["title" => "Products"]) ?>

<h1>Wegen</h1>

<a href="/product/new">Nieuwe weg</a>

<table>
    <thead>
    <tr>
        <th>Naam</th>
        <th>strooiduur</th>
        <th>lengte_km</th>
        <th>locatie</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($products as $product) : ?>
        <a>
            <td>
                <a href="/product/"<?= $product->getId() ?>">
                <?= $this->e($product->getName()) ?>
        </a>
        </td>
        <td><?= $this->e($product->getDescription()) ?></td>
        <td><?= $product->getSize() ?></td>
        <td><?= $product->getLocation() ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

