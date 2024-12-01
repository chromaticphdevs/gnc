<?php

	require_once LIBS.DS.'fastroute'.DS.'vendor/autoload.php';
    /**
     * ROUTE INSTANCIATION
     */
	$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) 
	{	
		/**
		 * GENEOLOGY ROUTER
		 */
		$r->addGroup('/team',function(FastRoute\RouteCollector $r) {
			$r->get('/details[/{userId}]' , 'Geneology@binary');
			$r->get('/regular-customers[/{userId}]','Geneology@unilevel');
		});

		$r->get('/test-of-character-passers[/{position}]' , 'TocController@index');
		
		$r->get('/users-for-follow-up' , 'FollowUps@index');
		$r->get('/users-for-follow-up/index' , 'FollowUps@index');
		$r->get('/users-for-follow-up/show[/{userIdSealed}]' , 'FollowUps@show');
		$r->get('/transactions', 'UserBinary@get_transactions');
		$r->get('/customers' , 'UserDirectsponsor@index');

		$r->addGroup('/company-customers-follow-ups' , function(FastRoute\RouteCollector $r){
			$r->get('/' , 'CompanyCustomerFollowUps@index');
			$r->get('/index' , 'CompanyCustomerFollowUps@index');
			$r->get('/update' , 'CompanyCustomerFollowUps@update');
			$r->get('/show[/{userIdSealed}]' , 'CompanyCustomerFollowUps@show');
		});
		/**
		 * link shortener
		 */
		$r->get('/refer[/{key}]', 'ShortenerController@index');
	});

	
	// Fetch method and URI from somewhere
	$httpMethod = $_SERVER['REQUEST_METHOD'];
	$uri = $_SERVER['REQUEST_URI'];

	// Strip query string (?foo=bar) and decode URI
	if (false !== $pos = strpos($uri, '?')) {
	    $uri = substr($uri, 0, $pos);
	}

	$uri = rawurldecode($uri);

	$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

	$hasRoute = false;

	switch ($routeInfo[0]) {
	    case FastRoute\Dispatcher::NOT_FOUND:
	        // ... 404 Not Found
	        break;
	    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
	        $allowedMethods = $routeInfo[1];
	        // ... 405 Method Not Allowed
	        break;
	    case FastRoute\Dispatcher::FOUND:
	        $handler = $routeInfo[1];
	        $vars = $routeInfo[2];
			$hasRoute = true;
				ROUTER_CONTROLLER_RUN($handler , $vars);
	        break;
	}
	
	return $hasRoute;
?>