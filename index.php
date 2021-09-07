<?php

ob_start();
session_start();

function loadClasses($class) {
	$dirs = [
		__DIR__ . '/controllers/', $_SERVER['DOCUMENT_ROOT'] . '/controllers/',

		__DIR__ . '/models/', $_SERVER['DOCUMENT_ROOT'] . '/models/',

		__DIR__ . '/classes/', $_SERVER['DOCUMENT_ROOT'] . '/classes/',
	];

	foreach ($dirs as $dir) {
		if (file_exists($dir . $class . '.php')) {
			require_once $dir . $class . '.php';
		}
		if (file_exists($dir . strtolower($class) . '.php')) {
			require_once $dir . strtolower($class) . '.php';
		}
	}
}


spl_autoload_register('loadClasses');
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';


if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/.env')) {
	$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT'], '/.env');
	$dotenv->load();
}

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
	$r->addRoute(['GET', 'POST'], '/', ['Store', 'index']);
	$r->addRoute(['GET', 'POST'], '/about', ['Store', 'about']);
	$r->addRoute(['GET', 'POST'], '/product', ['Store', 'product']);
	$r->addRoute(['GET', 'POST'], '/product/details/{id}', ['Store', 'product_details']);
	$r->addRoute(['GET', 'POST'], '/shopping-cart', ['Store', 'shopping_cart']);
	$r->addRoute(['GET', 'POST'], '/blog', ['Store', 'blog']);
	$r->addRoute(['GET', 'POST'], '/contact', ['Store', 'contact']);

	$r->addRoute(['GET', 'POST'], '/cart/add', ['Cart', 'add']);
	$r->addRoute(['GET', 'POST'], '/cart/get', ['Cart', 'get']);
	$r->addRoute(['GET', 'POST'], '/cart/clear', ['Cart', 'clear']);
	$r->addRoute(['GET', 'POST'], '/cart', ['Cart', 'show']);
	$r->addRoute(['GET', 'POST'], '/cart/update', ['Cart', 'update']);
	$r->addRoute(['GET', 'POST'], '/cart/remove/{id}', ['Cart', 'remove']);

	$r->addRoute(['GET', 'POST'], '/admin', ['Admin', 'index']);
	$r->addRoute(['GET', 'POST'], '/admin/login', ['Admin', 'login']);
	$r->addRoute(['GET', 'POST'], '/admin/logout', ['Admin', 'logout']);

	$r->addRoute(['GET', 'POST'], '/admin/categories', ['Admin', 'categories']);

	$r->addRoute(['GET', 'POST'], '/admin/products/add', ['Admin', 'products_add']);
	$r->addRoute(['GET', 'POST'], '/admin/products/list', ['Admin', 'products_list']);
	$r->addRoute(['GET', 'POST'], '/admin/products/list/{id}', ['Admin', 'products_id']);
	$r->addRoute(['GET', 'POST'], '/admin/products/update/{id}', ['Admin', 'products_update']);
	$r->addRoute(['GET', 'POST'], '/admin/products/delete/{id}', ['Admin', 'products_delete']);
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
switch ($routeInfo[0]) {
	case FastRoute\Dispatcher::NOT_FOUND:

		echo 'not found';

		break;
	case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
		$allowedMethods = $routeInfo[1];

		echo 'method not allowed';

		break;
	case FastRoute\Dispatcher::FOUND:
		try {
			$db = Connection::connect();
		} catch (Exception $e) {
			echo "Error in connection $e";
		}
		$classname = $routeInfo[1][0];
		$method = $routeInfo[1][1];

		$vars = $routeInfo[2];
		$vars['db'] = $db;
		$vars['classname'] = $classname;
		$vars['method'] = $method;

		$class = new $classname();
		call_user_func_array([$class, $method], [$vars, $httpMethod]);

		break;
}
ob_end_flush();
