<?php

declare(strict_types=1);

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7\HttpFactory;
use Nyholm\Psr7\Factory\Psr17Factory;

class HomeController
{
    
    public function index(): ResponseInterface
    {
        //$factory = new HttpFactory();
        $factory = new Psr17Factory();

        $json = file_get_contents(
            "https://weerlive.nl/api/weerlive_api_v2.php?key=ff1308b93f&locatie=sneek"
        );

        $data = json_decode($json, true);
        $weer = $data['liveweer'][0] ?? [];


        $plaats = $weer['plaats'] ?? 'Onbekend';
        $temperatuur = (float)($weer['temp'] ?? 10);
        $zicht = (int)($weer['zicht'] ?? 10);
        $soortWeer = strtolower($weer['samenv'] ?? 'onbekend');


        $alarmCode = (int)($weer['alarm'] ?? 0);
        $alarmTekst = match ($alarmCode) {
            1 => 'Code geel',
            2 => 'Code oranje',
            3 => 'Code rood',
            default => 'Code groen',
        };

        $wegen = [
            'A7',
            'N354',
            'Ring Sneek',
            'Industrieterrein Houkesloot',
            'Centrum Sneek'
        ];

        $hoofdwegen = ['A7', 'N354'];
        $lokaleWegen = ['Ring Sneek', 'Industrieterrein Houkesloot', 'Centrum Sneek'];

        $strooiwagens = 0;

        $moetStrooien = str_contains($soortWeer, 'sneeuw') || $temperatuur <= 0;

        if ($moetStrooien) {

            $strooiwagens += count($hoofdwegen);
            $strooiwagens += (int) ceil(count($lokaleWegen) / 2);
        }


        date_default_timezone_set('Europe/Amsterdam');
        $vandaag = date('d-m-Y');

        $output  = "Datum: {$vandaag}\n";
        $output .= "Plaats: {$plaats}\n";
        $output .= "Temperatuur: {$temperatuur} °C\n";
        $output .= "Zicht: {$zicht} m\n";
        $output .= "Weer: {$soortWeer}\n";
        $output .= "Weercode: {$alarmTekst}\n\n";
        $output .= "\nAantal strooiwagens nodig: {$strooiwagens}\n";
        $output .= "\nBeslissing per weg:\n";


        foreach ($wegen as $weg) {
            $actie = 'Geen actie';

            if (str_contains($soortWeer, 'sneeuw')) {
                $actie = 'Sneeuwschuiver + zoutstrooien';
            } elseif ($temperatuur <= 0) {
                $actie = 'Zoutstrooien';
            }

            $output .= "- {$weg}: {$actie}\n";
        }

        //$stream = Utils::streamFor("<pre>{$output}</pre>");
        //$stream = Utils::streamfor($output);
        $stream = $factory->createStream($output);
        $response = $factory->createResponse(200);
        return (new GuzzleResponse())->withBody($stream);
    }
}

//de wegen moeten bij elkaar opgeteld worden dus dan kan je zien hoeveel er in het totaal gestuurd moet worden voor op de wegen (afronden naar boven)