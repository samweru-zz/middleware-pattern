<?php

namespace App\Middleware;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ExceptionHandler implements MiddlewareInterface{

	private $env;

	public function __construct(string $env){

		$this->env = $env;
	}
	public function __invoke(Request $request, Response $response, callable $next){

		try {
			
			$response = $next($request, $response);
		} 
		catch (\Throwable $exception){

			if ($this->env === 'dev'){

				$response = new Response($exception->getMessage(), 500);
			} 
			else{
			
				$response = new Response('Im sorry, try again later.', 500);
			}
		}

		return $response;
	}
}