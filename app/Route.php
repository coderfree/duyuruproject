<?php 
$app->redirect('/deneme', 'http://www.google.com');

$app->get('/',function($req,$res,$args){

	//return $res->withStatus(400)->write('Bad Request');
	//return $res->withStatus(302)->withHeader('Location', 'http://wwww.google.com');
	

});

$app->group('/admin',function()
{	
	$this->get('/','HomeController:getIndex')->setName('home');
	$this->get('/auth/logout','AuthController:logout')->setName('admin.auth.logout');

	$this->get('/kullanici/olustur','KullaniciController:getOlustur')->setName('kullanici.olustur');
	$this->post('/kullanici/olustur','KullaniciController:postOlustur');

     #Kullanıcı routeları
	$this->get('/kullanici/listele','KullaniciController:getListele')->setName('kullanici.listele'); 
	$this->get('/kullanici/sil/{Id}','KullaniciController:getSil')->setName('kullanici.sil'); 
	$this->get('/kullanici/duzenle/{Id}','KullaniciController:getDuzenle')->setName('kullanici.duzenle'); 
	$this->post('/kullanici/duzenle/{Id}','KullaniciController:postDuzenle'); 
	$this->get('/kullanici/durum','KullaniciController:postDurum')->setName('kullanici.durum');
	 #Kullanıcı routeları

	 #Duyuru routeları
	$this->get('/duyuru/listele','DuyuruController:getListele')->setName('duyuru.listele'); 
	$this->get('/duyuru/olustur','DuyuruController:getOlustur')->setName('duyuru.olustur'); 
	$this->post('/duyuru/olustur','DuyuruController:postOlustur'); 
	$this->get('/duyuru/sil/{Id}','DuyuruController:getSil')->setName('duyuru.sil'); 
	$this->get('/duyuru/duzenle/{Id}','DuyuruController:getDuzenle')->setName('duyuru.duzenle'); 
	$this->post('/duyuru/duzenle/{Id}','DuyuruController:postDuzenle'); 
	$this->get('/duyuru/durum','DuyuruController:getDurum')->setName('duyuru.durum');   
	$this->get('/duyuru/sirala','DuyuruController:getSirala')->setName('duyuru.sirala');    
	 #Duyuru routeları
	 
	 #Dosya routeları
	
	$this->get('/dosya/yukle','FileController:getFileUpload')->setName('dosya.yukle');    
	$this->post('/dosya/yukle','FileController:postFileUpload');    

	 #Dosya routeları
	 

})->add(new App\Middlewares\AdminMiddleware($container));

$app->get('/admin/auth/login','AuthController:getLogin')->setName('admin.auth.login');
$app->post('/admin/auth/login','AuthController:postLogin');

##Sayfa Bulunamadı hataları için.....
$app->get('/404.html',function($request,$response){
	return $this->view->render($response,'ErrorHandlers/404.twig');
})->setName('404');

//return $res->withStatus(302)->withHeader('Location', 'http://wwww.google.com');
