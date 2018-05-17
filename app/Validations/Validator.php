<?php

namespace App\Validations;

use Respect\Validation\Validator as Respect;
use Respect\Validation\Exceptions\NestedValidationException;

class Validator
{
    protected $errors;

    public function validate($request, array $rules)
    {
        foreach ($rules as $field => $rule) {
            try {
                $rule->setName(ucfirst($field))->assert($request->getParam($field));
            } catch (NestedValidationException $e) {

                $e->findMessages([
                    'length' => 'Parola Çok Kısa. En az 5 karakter girim.',
                    'notEmpty' => 'Boş Bırakılamaz.',
                    'email' => 'E-posta formatı şu şekilde olmalı sen@mail.com',

                ]);
                $this->errors[$field] = $e->getMessages();
            }
        }

        $_SESSION['errors'] = $this->errors;
        return $this;
    }

    public function failed()
    {
        return !empty($this->errors);
    }

}