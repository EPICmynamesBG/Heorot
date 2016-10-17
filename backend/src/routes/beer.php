<?php

require_once __DIR__ . "/../models/beer.php";

/**
* @SWG\Get(
*     path="/beers",
*     summary="Get All",
*     description="Get all Beers",
*     tags={"Beer"},
*     @SWG\Response(
*         response=200,
*         description="Success",
*         @SWG\Schema(
*             ref="#/definitions/ArrayBeerSuccess"
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

$app->get('/beers', function ($request, $response, $args) {
    $beers = Beer::getAll();
    $output = new Response($beers);
    return $response->getBody()->write(json_encode($output));
});

/**
* @SWG\Get(
*     path="/beer/{id}",
*     summary="Get by Id",
*     description="Get a Beer by Id",
*     tags={"Beer"},
*     @SWG\Parameter(
*         description="ID of Beer to fetch",
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
*             ref="#/definitions/SingleBeerSuccess"
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
$app->get('/beer/{id}', function ($request, $response, $args) {
    if (!isset($args['id'])){
        throw new Exception("Missing parameter: Id", 400);
    }
    $beer = Beer::getById($args['id']);
    $out = new Response($beer);
    return $response->getBody()->write(json_encode($out));
});

/**
* @SWG\Post(
*     path="/beer",
*     summary="Create",
*     description="Create a Beer",
*     tags={"Beer"},
*     @SWG\Parameter(
*        name="body",
*        in="body",
*        description="Observation JSON Body",
*        required=true,
*        @SWG\Schema(ref="#/definitions/PostBody")
*     ),
*     @SWG\Response(
*         response=200,
*         description="Success",
*         @SWG\Schema(
*             ref="#/definitions/SingleBeerSuccess"
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

$app->post('/beer', function ($request, $response, $args) {
    $body = $request->getParsedBody();
    
    $beer = Beer::create($body);
    $output = new Response($beer);
    
    return $response->getBody()->write(json_encode($output));
});
