<?php 

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\Kullanici;
use Respect\Validation\Validator as v;  

class AuthController extends BaseController
{
	
	public function getLogin($request,$response)
	{
		return $this->view->render($response,'/admin/auth/login.twig');	
	}
	public function postLogin($request,$response)
	{
        /* $validation = $this->validator->validate($request, [
            'email' => v::noWhitespace()->notEmpty()->EmailValidate()
            
        ]);
         if ($validation->failed()) {
         	return "hata";
         }*/

         if ($this->auth->attempt($request->getParam('email'),$request->getParam('parola'))) {
         	return $response->withRedirect($this->container->router->pathFor('home'));
         }
         else return $response->withRedirect($this->container->router->pathFor('admin.auth.login'));

     }

     public function logout($request,$response)
     {
     	$this->container->auth->logout();
     	return $response->withRedirect($this->container->router->pathFor('admin.auth.login'));
     }


 }