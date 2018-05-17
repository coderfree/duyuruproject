<?php 
namespace App\Controllers;
use App\Models\Kullanici;

class HomeController extends BaseController
{
	
	public function getIndex($request,$response)
	{	
		#echo $request->getUri();
		/*$headers = $request->getHeaders();
		foreach ($headers as $name => $values) {
			echo $name . ": " . implode(", ", $values)."<br/>";
		}*/
		#var_dump($request->getHeader('User_Agent')); get array
		#echo $request->getHeaderLine('Accept'); get one header

		return $this->container->view->render($response,'admin/base.twig');
		
		
	}
}


