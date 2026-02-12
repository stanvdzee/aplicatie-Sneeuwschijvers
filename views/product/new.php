<?php $this->layout('layout', ["title" => "New Product"]); ?>

<h1>nieuwe weg</h1>

<form method="post">
    <div>
        <label for="name">Naam</label>
        <input type="text" id="name" name="name">
    </div>
    <div>
        <label for="description">Strooiduur</label>
        <textarea id="description" name="description"></textarea>
    </div>
    <div>
        <label for="size">Lengte_km</label>
        <input type="number" id="size" name="size" min="0">
    </div>
    <div>
        <label for="location">Locatie</label>
        <input type="text" id="location" name="location">
    </div>

    <button type="submit">Maak weg aan</button>
</form>