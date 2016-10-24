<?php

require_once __DIR__ . "/../models/style.php";

/**
* @SWG\Get(
*     path="/styles",
*     summary="Get All",
*     description="Get all Styles",
*     tags={"Style"},
*     @SWG\Response(
*         response=200,
*         description="Success",
*         @SWG\Schema(
*             ref="#/definitions/ArrayStyleSuccess"
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

$app->get('/styles', function ($request, $response, $args) {
    $styles = Style::getAll();
    $output = new Response($styles);
    return $response->getBody()->write(json_encode($output));
});

/**
* @SWG\Get(
*     path="/style/{id}",
*     summary="Get by Id",
*     description="Get a Style by Id",
*     tags={"Style"},
*     @SWG\Parameter(
*         description="ID of Style to fetch",
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
*             ref="#/definitions/SingleStyleSuccess"
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
$app->get('/style/{id}', function ($request, $response, $args) {
    if (!isset($args['id'])){
        throw new Exception("Missing required field: id", 400);
    }
    $style = Style::getById($args['id']);
    if (!isset($style)){
        throw new Exception("Style with id ". $args['id'] . " not found", 400);
    }
    
    $out = new Response($style);
    return $response->getBody()->write(json_encode($out));
});

/**
* @SWG\Post(
*     path="/style",
*     summary="Create",
*     description="Create a Style",
*     tags={"Style"},
*     @SWG\Parameter(
*        name="body",
*        in="body",
*        description="Observation JSON Body",
*        required=true,
*        @SWG\Schema(ref="#/definitions/StylePostBody")
*     ),
*     @SWG\Response(
*         response=200,
*         description="Success",
*         @SWG\Schema(
*             ref="#/definitions/SingleStyleSuccess"
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

$app->post('/style', function ($request, $response, $args) {
    $body = $request->getParsedBody();
    
    if (!isset($body['name'])){
        throw new Exception("Missing required field: name", 400);
    }
    
    $style = Style::create($body);
    $output = new Response($style);
    
    return $response->getBody()->write(json_encode($output));
});
