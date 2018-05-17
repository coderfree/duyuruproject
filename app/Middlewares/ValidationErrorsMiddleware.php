<?php
/**
 * kisilik - ValidationErrorsMiddleware.php
 *
 * Oluşturan: Ekrem Eşref KILINÇ
 * Taih: 8.04.2018
 * Saat: 02:07
 */

namespace App\Middlewares;

class ValidationErrorsMiddleware extends Middleware
{
	public function __invoke($request, $response, $next)
	{
		if (isset($_SESSION['errors']))
			$this->container->view->getEnvironment()->addGlobal('errors', $_SESSION['errors']);
		unset($_SESSION['errors']);
		$response = $next($request, $response);
		return $response;
	}

}
