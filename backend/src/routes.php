<?php
// Routes
//the root route which redirects to Swagger Docs
//DO NOT MODIFY OR SWAGGER COMMENT THIS ROUTE
$app->get('/', function ($request, $response, $args) {
    //redirect to Swagger Docs
    return $response->withStatus(302)->withHeader("Location", "http://localhost:8888/backend/docs/index.html");
});
require __DIR__ . "/routes/brewery.php";
require __DIR__ . "/routes/beer.php";
require __DIR__ . "/routes/search.php";
require __DIR__ . "/routes/style.php";