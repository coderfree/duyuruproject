<?php
/**
 * kisilik - OldInputMiddleware.php
 *
 * Oluşturan: Ekrem Eşref KILINÇ
 * Taih: 8.04.2018
 * Saat: 22:28
 */

namespace App\Middlewares;

class OldInputMiddleware extends Middleware
{
    public function __invoke($request, $response, $next)
    {
        if (isset($_SESSION['errors']))
            $this->container->view->getEnvironment()->addGlobal('old', $_SESSION['old']);
        $_SESSION['old'] = $request->getParams();
        $response = $next($request, $response);
        return $response;
    }

}