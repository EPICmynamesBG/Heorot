<?php

use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7\Request;

class BreweryDB {
    
    private $API_KEY;
    
    private $API_URL;
    
    function __construct() {
        $this->API_URL = "http://api.brewerydb.com/v2";
        $this->API_KEY = "8a3e6a9150d6f1b10b2f0a4d1f07c4c5";
        $this->client = new GuzzleHttp\Client();
    }
    
    private function buildSearchURL($searchStr, $searchType) {
        return $this->API_URL . "/search?key=". $this->API_KEY . "&q=". $searchStr . "&type=".$searchType;
    }
    
    private function parseTopResult($response) {
        $body = json_decode($response->getBody()->getContents(), true); 
        $requestLimit = $response->getHeader('X-Ratelimit-Limit')[0];
        $remainingRequests = $response->getHeader('X-Ratelimit-Remaining')[0];
        $parsed = $body['data'][0];
        $parsed['requests'] = array(
            'limit' => $requestLimit,
            'remaining' => $remainingRequests
        );
        return $parsed;
    }
    
    public function getInfoForBeer($beerName) {
        $url = $this->buildSearchURL($beerName, "beer");
        
        try {
            $response = $this->client->request('GET', $url);
        } catch (GuzzleHttp\Exception\BadResponseException $e) {
            return null;
        }

        $parsed = $this->parseTopResult($response, $beerName);
      
        return $parsed;
    }
    
    public function getInfoForBrewery($brewName) {
        $url = $this->buildSearchURL($brewName, "brewery");
        try {
            $response = $this->client->request('GET', $url);
        } catch (GuzzleHttp\Exception\BadResponseException $e) {
            return null;
        }
        
        $parsed = $this->parseTopResult($response);
        
        return $parsed;
    }
    
}