<?php
require './vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

function sirenne_api($api_url, $api_key, $api_search)
{
    $client = new Client();
    try {
        $res = $client->request('GET', $api_url. $api_search, [
            'headers' => [
                'X-INSEE-Api-Key-Integration' => $api_key,
            ]
        ]);
        return json_decode($res->getBody(), true);
    } catch (GuzzleException $e) {
        return $e->getMessage();
    }
}
