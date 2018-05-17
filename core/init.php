<?php 

require "vendor/autoload.php";

use Respect\Validation\Validator as v;


$app= new Slim\App(
	[
		'settings' => [
			'displayErrorDetails' => true,
			'addContentLengthHeader'=>false,
			'db' => [
				'driver' => 'mysql',
				'host' => 'localhost',
				'database' => 'duyuruweb',
				'username' => 'root',
				'password' => '',
				'charset'   => 'utf8',
				'collation' => 'utf8_turkish_ci',
				'prefix'    => '',
			]
		]
	]	
);

$container=$app->getContainer();

$capsule= new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db']= function($container) use ($capsule)
{
	return $capsule;
};

$container['auth']=function($container)
{
	return new App\Auth\Auth;
};

$container['flash'] = function () {
	return new \Slim\Flash\Messages();
};

$container['upload_directory'] = realpath(__DIR__ . '/../public/image');

$container['view'] = function ($container) {
	$view=  new \Slim\Views\Twig('app/Views', [
		'cache' => false]);

	$view->addExtension(new \Slim\Views\TwigExtension(
		$container->router,
		$container->request->getUri()
	));

	$view->getEnvironment()->addGlobal('auth',[
		'checkadmin'=> $container->auth->checkadmin(),
		'admin'=> $container->auth->admin()
	]);

	$view->getEnvironment()->addGlobal('flash',$container->flash);

	return $view;
};

$container['validator']=function($container)
{
	return new App\Validations\Validator;
};


$container['BaseController']= function($container){
	return new App\Controllers\HomeController($container);
};

$container['HomeController']= function($container){
	return new App\Controllers\HomeController($container);
};

$container['AuthController']= function($container){
	return new App\Controllers\Auth\AuthController($container);
};

$container['KullaniciController']= function($container){
	return new App\Controllers\KullaniciController($container);
};

$container['DuyuruController']= function($container){
	return new App\Controllers\DuyuruController($container);
};
$container['FileController']= function($container){
	
	return new App\Controllers\FileController($container);
};

##Sayfa Bulunamadı hataları için.....
$container['notFoundHandler'] = function ($container) {
	return function ($request, $response) use ($container) {
		return $container['response']
		->withStatus(404)
		->withHeader('Content-Type', 'text/html')
		->withRedirect($container->router->pathFor('404'),301);
	};
};


$container["csrf"] = function ($container) {
	return new \Slim\Csrf\Guard;
};

$app->add(new \App\Middlewares\ValidationErrorsMiddleware($container));     
$app->add(new \App\Middlewares\OldInputMiddleware($container));
$app->add(new \App\Middlewares\CsrfViewMiddleware($container));  

$app->add($container->csrf);  
v::with('App\\Validations\\Rules');

require_once "app/Route.php";
