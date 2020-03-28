<?php
namespace App\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class Taxi {
    public $name = '';
    public $type = '';
    public $sits = '';
    public $luggage = '';
    public $service = '';
    public $meeting = false;
    public $price = null;

    public function __construct($obj) {
        if ($obj) {
            $objArr = (array)$obj;
            $this->name = $this->getV($objArr, 'name');
            $this->type = $this->getV($objArr, 'type');
            $this->sits = $this->getV($objArr, 'sits');
            $this->luggage = $this->getV($objArr, 'luggage');
            $this->meeting = $this->getV($objArr, 'meeting');
            $this->service = $this->getV($objArr, 'service');
            $this->price = $this->getV($objArr, 'price');
        }
    }

    private function getV($obj, $prop) {
        return array_key_exists($prop, $obj) ? $obj[$prop] : null;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('name', new Assert\Length(['min' => 1]));
        $metadata->addPropertyConstraint('name', new Assert\NotNull());
        
        $metadata->addPropertyConstraint('type', new Assert\Length(['min' => 1]));
        $metadata->addPropertyConstraint('type', new Assert\NotNull());
        
        $metadata->addPropertyConstraint('sits', new Assert\Length(['min' => 1]));
        $metadata->addPropertyConstraint('sits', new Assert\NotNull());
        
        $metadata->addPropertyConstraint('luggage', new Assert\Length(['min' => 1]));
        $metadata->addPropertyConstraint('luggage', new Assert\NotNull());
        
        $metadata->addPropertyConstraint('service', new Assert\Length(['min' => 1]));
        $metadata->addPropertyConstraint('service', new Assert\NotNull());

        $metadata->addPropertyConstraint('price', new Assert\Positive());
        $metadata->addPropertyConstraint('price', new Assert\NotNull());

    }
}