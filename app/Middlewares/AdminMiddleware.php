<?php 

namespace App\Middlewares;

class AdminMiddleware extends Middleware
{
	public function __invoke($request,$response,$next)
	{
		if (!$this->container->auth->checkadmin()) {
			$this->container->flash->addMessage('hata','Bu alanı görmek için önce giriş yapmalısınız!!!');
			return $this->container->view->render($response,'admin/auth/login.twig');
		}
		$response= $next($request,$response);		
		return $response;
	}
}
