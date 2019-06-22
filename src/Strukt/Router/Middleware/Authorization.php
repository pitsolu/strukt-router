<?php

namespace Strukt\Router\Middleware;

use Strukt\Http\Response;
use Strukt\Http\Request;
use Strukt\Core\Registry;
use Strukt\Event\Event;

class Authorization implements MiddlewareInterface{

	private $authorizationEvent;

	public function __construct(Event $authorizationEvent){

		$this->authorizationEvent = $authorizationEvent;
	}

	public function __invoke(Request $request, Response $response, callable $next){

		$access = $this->authorizationEvent->exec();

		if(!is_array($access))
			throw new \Exception("Authorization event expects array object!");

		Registry::getInstance()->set("access", $access);

		return $next($request, $response);
	}
}