<?php
ob_start();
session_start();

require $_SERVER['DOCUMENT_ROOT'] . '/includes/autoloadregister.php';  // auto load classes with spl autoload register
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';  // auto load vendor classes (such as FastRoute)

if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/.env')) {  // load .env locally
	$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT'], '/.env');
	$dotenv->load();
}

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
	foreach (Utils::routes() as $route) {  // routes are defined as {  methods, path, handler } 
		list($allowedMethods, $path, $handler) = $route;
		$r->addRoute($allowedMethods, $path, $handler);
	}
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
