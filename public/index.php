<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

define('INC_ROOT', dirname(__DIR__));
define('DES_ROOT', substr(INC_ROOT, 0, strlen(INC_ROOT) - 3 ) . '/public/img/designs/');
define('ART_ROOT', substr(INC_ROOT, 0, strlen(INC_ROOT) - 3 ) . '/public/img/art-photos/');

$app = new \Slim\App([
	'settings' => [
		'displayErrorDetails' => true
	]
]);

$app->add(function ($req, $res, $next) {

    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->withHeader('Content-Type','application/json');
});



require_once(INC_ROOT . '/config/database.php');
require_once('../api/vehicles.php');

$app->run();

?>
