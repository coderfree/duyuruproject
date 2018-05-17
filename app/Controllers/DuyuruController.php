<?php
namespace App\Controllers;

use App\Models\Duyuru;

class DuyuruController extends BaseController
{
	
	public function getListele($request,$response)
	{
		$duyuru=Duyuru::all()->sortBy('rank');	
		$this->container->view->render($response,'admin/duyuru/listele.twig',['duyurular'=>$duyuru]);

	}
	public function getOlustur($request,$response)
	{		
		$this->container->view->render($response,'admin/duyuru/olustur.twig');
	}
	public function postOlustur($request,$response)
	{

		$donen= Duyuru::create([
			'baslik'=>$request->getParam('baslik'),
			'metin'=>$request->getParam('metin'),
			'rank'=>Duyuru::max('rank')+1,
			'isactive'=>$request->getParam('isactive')?1:0
		]);

		if ($donen>0){
			$this->flash->addMessage('info','Duyuru olusturuldu');
			return 	$response->withRedirect($this->router->pathFor('duyuru.listele'));
		}
	}
	public function getDurum($request)
	{   
		$durum=$request->getParam('choices')[0];
		$Idr=trim($request->getParam('choices')[1]);
		$Idr=(explode('_',$Idr))[1];
		
		$donen=Duyuru::where('Id','=',$Idr)->update([
			'isactive'=> $durum =='true'?1:0
		]);
		return $Idr;
	}
	public function getSil($request,$response,$args)
	{		
		$DuyuruId=$args['Id'];
		$donen = Duyuru::where('Id',$DuyuruId)->delete();
		if ($donen>0) {
			$this->flash->addMessage('info', 'Duyuru başarı ile silindi'); 
		}
		else 
		{
			$this->flash->addMessage('uyari', 'Duyuru silenemedi'); 
		}
		return $response->withRedirect($this->router->pathFor('duyuru.listele')); 
	}


	public function getDuzenle($request,$response,$args)
	{
		$Id=$args['Id'];
		if (isset($Id)) {
			$donen=Duyuru::where('Id',$Id)->first();
			if (isset($donen)) {
				return $this->container->view->render($response,'admin/duyuru/duzenle.twig',['duyuru'=>$donen]);
			}
		}

		return $response->withRedirect($this->router->pathFor('duyuru.listele')); 
	}
	public function postDuzenle($request,$response,$args)
	{	
		
		$Id=$args['Id'];	

		$donen = Duyuru::where('Id',$Id)->update([
			'baslik'=>$request->getParam('baslik'),
			'metin'=> $request->getParam('metin'),		
			'isactive'=> $request->getParam('isactive')?1:0
		]);
		if ($donen>0) {
			$this->flash->addMessage('info', 'Kayıt Başarılı'); 
		}
		else 
		{
			$this->flash->addMessage('uyari', 'Kayıt Başarısız'); 
		}
		return $response->withRedirect($this->router->pathFor('duyuru.listele')); 

	}

	public function getSirala($request)
	{
		$durum=$request->getParam('sira');
		parse_str($durum,$myarray);
		//print_r($myarray['ord']);
		foreach ($myarray['ord'] as $ord => $id) {
			Duyuru::where('Id',$id)->where('rank',"!=",$ord)->update([
				'rank'=> $ord
			]);
		}
	}
	

}