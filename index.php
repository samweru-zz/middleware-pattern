<?php

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

$loader = require "vendor/autoload.php";
$loader->add('App', __DIR__.'/src/');

$app = new App\Kernel(Request::createFromGlobals());
$app->middlewares(array(
	
	"execption" => new App\Middleware\ExceptionHandler("dev"),
	"session" => new App\Middleware\Session(new Session()),
	"router" => new App\Middleware\Router
));

$app->map("/", function(Request $request){

	return new Response('Hello world', 200);
});

$app->map("/tryme", function(Request $request){

	// print_r($request->getSession());

	return new Response("You've been tried!", 200);
});

$app->map("/foo", "App\Controller\FooController@run");
$app->map("/start/pgs", "App\Controller\StartpageController@run");

$response = $app->run();

echo $response->getContent();