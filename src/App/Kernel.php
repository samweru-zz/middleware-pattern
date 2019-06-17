<?php

namespace App;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class Kernel{

	public function __construct(Request $request,string $env = null, bool $debug = false){

		$this->request = $request;
		$this->response = new Response();

		$this->debug = $debug;
		$this->env = $env;
	}

	public function middlewares(array $middlewares){

		$this->middlewares = $middlewares;
	}

	public function map($path, $controller) {

		$this->middlewares["router"]->endpoint($path, $controller);
	}

	public function run() : Response{

		$runner = new Runner($this->middlewares);
		$response = $runner($this->request, $this->response);
			
		return $response;
	}
}