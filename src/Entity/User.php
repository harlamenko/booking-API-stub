<?php
namespace App\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class User {
    public $username = '';
    public $password = '';

    public function __construct($username, $password) {
        $this->username = $username;
        $this->password = $password;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('username', new Assert\Length(['min' => 1]));
        $metadata->addPropertyConstraint('username', new Assert\NotNull());
        
        $metadata->addPropertyConstraint('password', new Assert\Length(['min' => 1]));
        $metadata->addPropertyConstraint('password', new Assert\NotNull());
    }
}