<?php 

namespace App\Auth;

use App\Models\Kullanici;
/**
* Yetkilendirme ayarları Session v.s.
*/

class Auth
{
	public function admin()
	{
		return $this->checkadmin()? Kullanici::getWithId($_SESSION['admin']):false;	
	}

	public function checkadmin()
	{
		return isset($_SESSION['admin']);
	}
	
	public function attempt($email,$password)
	{
		$user= Kullanici::getWithEmail($email);
		if (!$user) {
			return false;
		}
		if (password_verify($password,$user->parola)) {
			$_SESSION['admin']=$user->Id;
			return true;
		}
		return false;
	}

	public function logout()
	{
		session_destroy();
	}

}