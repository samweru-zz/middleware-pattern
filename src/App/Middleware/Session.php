<?php

namespace App\Middleware;

use Symfony\Component\HttpFoundation\Session\Session as SfSession;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class Session implements MiddlewareInterface{

	private $session;

	public function __construct(SfSession $session){

		$this->session = $session;
	}

	public function __invoke(Request $request, Response $response, callable $next){

		$this->session->start();

		$request->setSession($this->session);

		return $next($request, $response);
	}
}