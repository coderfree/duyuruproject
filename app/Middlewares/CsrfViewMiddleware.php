<?php

namespace App\Middlewares;

class CsrfViewMiddleware extends Middleware
{
    public function __invoke($request, $response, $next)
    {
        $this->container->view->getEnvironment()->addGlobal('csrf', [
            'field' => '
            <input type="hidden" name="' . $this->container->csrf->getTokenNameKey() . '" value="' . $this->container->csrf->getTokenName() . '" id="'. $this->container->csrf->getTokenNameKey().'" >
            <input type="hidden" name="' . $this->container->csrf->getTokenValueKey() . '" value="' . $this->container->csrf->getTokenValue() . '" id="'. $this->container->csrf->getTokenValueKey().'" >
            '
        ]);
        $response = $next($request, $response);
        return $response;
    }

}