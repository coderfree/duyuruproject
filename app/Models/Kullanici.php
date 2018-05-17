<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kullanici extends Model
{
	
	protected $table='kullanici';

	protected $fillable=[
		'email',
		'parola',
		'adsoyad',
		'isactive'	
	];
	protected $primarykey='Id';

	public static function getWithId($Id)
	{
		return Kullanici::where('Id','=',$Id)->first();
	}

	public static function getWithEmail($email)
	{
		return Kullanici::where('email','=',$email)->first();
	}

	 public function emailValidate($email)
    {
        $donen = $this->where('email', $email)->first();
        return !isset($donen);

    }
	
}