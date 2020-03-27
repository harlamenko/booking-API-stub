<?php

namespace App\Entity;

use Symfony\Component\Validator\ConstraintViolationList;

class Validator {
    static function humanize(ConstraintViolationList $errors) {
        $res = ['invalidFields' => []];
        
        foreach($errors->getIterator() as $i => $violation) {
            $res['invalidFields'][] = [
                "field" => $violation->getPropertyPath(),
                "message" => $violation->getMessage()
            ];
        }
        
        return $res;
    }
}