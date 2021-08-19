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

new Store();


if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/.env')) {
	$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT'], '/.env');
	$dotenv->load();
}

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
	$r->addRoute(['GET', 'POST'], '/', ['Store', 'index']);
	$r->addRoute(['GET', 'POST'], '/about', ['Store', 'about']);
	$r->addRoute(['GET', 'POST'], '/product', ['Store', 'product']);
	$r->addRoute(['GET', 'POST'], '/shopping-cart', ['Store', 'shopping_cart']);
	$r->addRoute(['GET', 'POST'], '/blog', ['Store', 'blog']);
	$r->addRoute(['GET', 'POST'], '/contact', ['Store', 'contact']);
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
	$uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

?>

<!DOCTYPE html>
<html lang="en">

<body class="animsition">
	<?php

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
			}
			$classname = $routeInfo[1][0];
			$method = $routeInfo[1][1];

			$vars = $routeInfo[2];

			// HEADER
			if ($httpMethod == 'GET') {
				$_SESSION['TITLE'] = $method;

				require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/head.php");

				if ($method == "index") {
					require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/header.php");
				} else {
					require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/header2.php");
				}

				require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/cart.php");
			}

			$class = new $classname();
			call_user_func_array([$class, $method], [$vars, $httpMethod]);

			// FOOTER
			if ($httpMethod == 'GET') {
				require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php");
				require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/backtotop.php");
				require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/modal1.php");
				require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/scripts.php");
			}

			break;
	}
	?>
</body>

</html>

<?php

ob_end_flush();

?>