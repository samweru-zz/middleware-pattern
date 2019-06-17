<?php

namespace App\Middleware;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class Router implements MiddlewareInterface{

	public function endpoint($path, $route){

		$this->routes[$path] = $route;
	}

	public function __invoke(Request $request, Response $response, callable $next){

	 	$uri = $request->getRequestUri();

	 	if(array_key_exists($uri, $this->routes)){

	 		$route = $this->routes[$uri];

	 		if(is_string($route)){

	 			list($class, $method) = explode("@", $route);

	 			$rClass = new \ReflectionClass($class);
	 			$newClass = $rClass->newInstance();

	 			$response = $newClass->$method($request);
	 		}
	 		
	 		if(is_callable($route)){
	 			
	 			$response = $route($request);
	 		}
	 	}
	 	else{

	 		$response->setStatusCode(404);
			$response->setContent('Not Found');
	 	}

		return $next($request, $response);
	}
}