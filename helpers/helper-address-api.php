<?php
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

function address_api($address)
{
    $client = new Client();
    try {
        $res = $client->request('GET', 'https://api-adresse.data.gouv.fr/search/?q=' . $address);
        return json_decode($res->getBody(), true);
    } catch (GuzzleException $e) {
        return $e->getMessage();
    }
}
