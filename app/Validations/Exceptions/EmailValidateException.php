<?php 

namespace App\Validations\Exceptions;
/**
* EmailValidate Exception hata yakalama
*/
use Respect\Validation\Exceptions\ValidationException;
class EmailValidateException extends ValidationException
{
	
	public static $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'Bu email adresi ile zaten uye olunmuş.',
        ]
    ];
}