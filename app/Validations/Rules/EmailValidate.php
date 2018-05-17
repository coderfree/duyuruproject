<?php 
namespace App\Validations\Rules;
/**
* Sistem de mailin olup olmadığını doğruluyor.
*/

use Respect\Validation\Rules\AbstractRule;
use App\Models\Kullanici;
class EmailValidate extends AbstractRule
{
	public function validate($input)
	{
		$user = new Kullanici;
		return $user->emailValidate($input);
	}
}