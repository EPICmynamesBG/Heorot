<?php

require_once __DIR__ . "/../models/beer.php";
require_once __DIR__ . "/../models/brewery.php";

/**
* @SWG\Get(
*     path="/search",
*     summary="Search",
*     description="Search for a beer/brewery",
*     tags={"Search"},
*     @SWG\Parameter(
*         description="part of a Beer name",
*         in="query",
*         name="beer",
*         required=false,
*         type="string"
*     ),
*     @SWG\Parameter(
*         description="part of a Brewery name",
*         in="query",
*         name="brewery",
*         required=false,
*         type="string"
*     ),
*     @SWG\Response(
*         response=200,
*         description="Success",
*         @SWG\Schema(
*             ref="#/definitions/SearchSuccess"
*         )
*     ),
*     @SWG\Response(
*         response="default",
*         description="Error",
*         @SWG\Schema(
*             ref="#/definitions/Error"
*         )
*     )
* )
*/
$app->get('/search', function ($request, $response, $args) {
    $beer = $request->getQueryParam('beer');
    $brewery = $request->getQueryParam('brewery');
    if (!isset($beer) && !isset($brewery)){
        throw new Exception("No search parameters provided", 400);
    }
    
    $beerList = array();
    $breweryList = array();
    if (isset($beer)){
      $beerList = Beer::search($beer);
    }
    if (isset($brewery)){
      $breweryList = Brewery::search($brewery);
    }
    
    $combined = array(
        'beers' => $beerList,
        'breweries' => $breweryList
    );
    
    $out = new Response($combined);
    return $response->getBody()->write(json_encode($out));
});