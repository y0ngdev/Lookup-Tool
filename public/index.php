<?php


use App\Twilio\Lookup;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Selective\BasePath\BasePathMiddleware;
use Slim\Factory\AppFactory;

require_once __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

// $app->add(new BasePathMiddleware($app));

// $app->addErrorMiddleware(true, true, true);
$app->get('/phonenumbers/{number}', function (Request $request, Response $response, array $param) {

	$data = new Lookup();

	$response->getBody()->write($data->fetch($param['number']));
	return $response->withHeader('content-type', 'application/json')
		->withStatus(200);
});

$app->run();
