<?php 
namespace App\Controllers;
use App\Models\Kullanici;
use Respect\Validation\Validator as v; 
class KullaniciController extends BaseController
{
	
	public function getOlustur($request,$response)
	{		
		return $this->container->view->render($response,'admin/kullanici/olustur.twig');
	}
	public function postOlustur($request,$response)
	{	
		$validation = $this->validator->validate($request, [
			'email' => v::noWhitespace()->notEmpty()->EmailValidate(),
			'adsoyad' => v::notEmpty(),
			'parola' => v::noWhitespace()->notEmpty(),
		]);

		if ($validation->failed()) {
			return $response->withRedirect($this->router->pathFor('kullanici.olustur'));      		
		}
		
		$kullanici= Kullanici::create([
			'email'=>$request->getParam('email'),
			'adsoyad'=>$request->getParam('adsoyad'),
			'parola'=>password_hash($request->getParam('parola'),PASSWORD_DEFAULT),
			'isactive'=>$request->getParam('isactive')?1:0
		]);
		if($kullanici>0){
			$this->flash->addMessage('info', 'Kullanıcı başarı ile oluşturuldu.'); 
			return $response->withRedirect($this->router->pathFor('kullanici.listele')); 
		}

	}

	public function getListele($request,$response)
	{		
		/*$namekey=$this->container->csrf->getTokenNameKey();
		$name= $request->getAttribute($namekey);
		$valuekey=$this->container->csrf->getTokenValueKey();
		$value= $request->getAttribute($valuekey);*/

		$list=Kullanici::all();
		return $this->container->view->render($response,'admin/kullanici/listele.twig',['users'=>$list]);
	}

	public function getSil($request,$response,$args)
	{		
		$UserId=$args['Id'];
		$donen = Kullanici::where('Id',$UserId)->delete();
		if ($donen>0) {
			$this->flash->addMessage('info', 'Kullanıcı başarı ile silindi'); 
		}
		else 
		{
			$this->flash->addMessage('uyari', 'Kullanıcı silenemedi'); 
		}
		return $response->withRedirect($this->router->pathFor('kullanici.listele')); 
	}

	public function postDurum($request)
	{   
		$durum=$request->getParam('choices')[0];
		$Idr=trim($request->getParam('choices')[1]);
		$Idr=(explode('_',$Idr))[1];
		
		$donen=Kullanici::where('Id','=',$Idr)->update([
			'isactive'=> $durum =='true'?1:0
		]);

		return $Idr;
	}

	public function getDuzenle($request,$response,$args)
	{
		$Id=$args['Id'];
		if (isset($Id)) {
			$donen=Kullanici::where('Id',$Id)->first();
			if (isset($donen)) {
				return $this->container->view->render($response,'admin/kullanici/duzenle.twig',['user'=>$donen]);
			}
		}

		return $response->withRedirect($this->router->pathFor('kullanici.listele')); 
	}
	public function postDuzenle($request,$response)
	{	
		
		$Id=$request->getParam('Id');	
		$parola= $request->getParam('yeniparola')? password_hash($request->getParam('parola'),PASSWORD_DEFAULT):Kullanici::where('Id',$Id)->first()->parola;	
		$donen = Kullanici::where('Id',$Id)->update([
			'adsoyad'=>$request->getParam('adsoyad'),
			'parola'=> $parola,			
			'isactive'=> $request->getParam('isactive')?1:0
		]);
		if ($donen>0) {
			$this->flash->addMessage('info', 'Kayıt Başarılı'); 
		}
		else 
		{
			$this->flash->addMessage('uyari', 'Kayıt Başarısız'); 
		}
		return $response->withRedirect($this->router->pathFor('kullanici.listele')); 

	}

}


