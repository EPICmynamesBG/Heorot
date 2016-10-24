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
*     @SWG\Parameter(
*         description="part of a Style name",
*         in="query",
*         name="style",
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
    $style = $request->getQueryParam('style');
    if (!isset($beer) && !isset($brewery) && !isset($style)){
        throw new Exception("No search parameters provided", 400);
    }
    
    $beerList = array();
    $breweryList = array();
    $styleList = array();
    if (isset($beer)){
      $beerList = Beer::search($beer);
    }
    if (isset($brewery)){
      $breweryList = Brewery::search($brewery);
    }
    if (isset($style)){
      $styleList = Style::search($style);
    }
    
    $combined = array(
        'beers' => $beerList,
        'breweries' => $breweryList,
        'styles' => $styleList
    );
    
    $out = new Response($combined);
    return $response->getBody()->write(json_encode($out));
});