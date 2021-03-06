<?php

namespace Strukt\Provider;

use Strukt\Router\RouteCollection;
use Strukt\Router\Route;
use Strukt\Event;
use Strukt\Contract\AbstractProvider;
use Strukt\Contract\ProviderInterface;
use Strukt\Ref;

class Router extends AbstractProvider implements ProviderInterface{

	public function __construct(){

		$this->core()->set("app.router", new RouteCollection());
	}

	public function register(){

		$this->core()->set("app.service.router", new Event(
			
			function($pattern, $route_func, $http_method, $name){

				if(is_string($route_func)){

		 			list($class, $method) = explode("@", $route_func);

		 			$route_func = Ref::create($class)
		 				->make()
		 				->method($method)
		 				->getClosure();
		 		}

		 		$route = new Route($pattern, $route_func, $http_method, $name);

				$this->core()->get("app.router")->addRoute($route);
			}
		));
	}
}