<?php

require_once __DIR__ . "/../models/brewery.php";

/**
* @SWG\Get(
*     path="/breweries",
*     summary="Get All",
*     description="Get all Beers",
*     tags={"Brewery"},
*     @SWG\Response(
*         response=200,
*         description="Success",
*         @SWG\Schema(
*             ref="#/definitions/ArrayBrewerySuccess"
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

$app->get('/breweries', function ($request, $response, $args) {
    $brews = Brewery::getAll();
    $output = new Response($brews);
    return $response->getBody()->write(json_encode($output));
});

/**
* @SWG\Get(
*     path="/brewery/{id}",
*     summary="Get by Id",
*     description="Get a Brewery by Id",
*     tags={"Brewery"},
*     @SWG\Parameter(
*         description="ID of Brewery to fetch",
*         format="int64",
*         in="path",
*         name="id",
*         required=true,
*         type="integer"
*     ),
*     @SWG\Response(
*         response=200,
*         description="Success",
*         @SWG\Schema(
*             ref="#/definitions/SingleBrewerySuccess"
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
$app->get('/brewery/{id}', function ($request, $response, $args) {
    if (!isset($args['id'])){
        throw new Exception("Missing required field: id", 400);
    }
    $brew = Brewery::getById($args['id']);
    if ($brew != null){
        $brew->addExtendedInfo();
    } else {
        throw new Exception("Beer with id ". $args['id'] . " not found", 400);
    }
    $out = new Response($brew);
    return $response->getBody()->write(json_encode($out));
});

/**
* @SWG\Post(
*     path="/brewery",
*     summary="Create",
*     description="Create a Brewery",
*     tags={"Brewery"},
*     @SWG\Parameter(
*        name="body",
*        in="body",
*        description="Observation JSON Body",
*        required=true,
*        @SWG\Schema(ref="#/definitions/BreweryPostBody")
*     ),
*     @SWG\Response(
*         response=200,
*         description="Success",
*         @SWG\Schema(
*             ref="#/definitions/SingleBrewerySuccess"
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

$app->post('/brewery', function ($request, $response, $args) {
    $body = $request->getParsedBody();
    
    if (!isset($body['name'])){
        throw new Exception("Missing required field: name", 400);
    }
    
    $brew = Brewery::create($body);
    $output = new Response($brew);
    
    return $response->getBody()->write(json_encode($output));
});
