<?php
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

function commune_api($api_search)
{
    $client = new Client();
    try {
        $res = $client->request('GET', 'https://geo.api.gouv.fr/communes?codePostal='. $api_search. '&fields=departement');
        return json_decode($res->getBody(), true);
    } catch (GuzzleException $e) {
        return $e->getMessage();
    }
}
