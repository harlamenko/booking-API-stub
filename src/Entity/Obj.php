<?php
namespace App\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class Obj {
    public $phone_number = '';
    public $object_name = '';
    public $stars = 0;
    public $host_name = '';
    public $country = '';
    public $city = '';
    public $street = '';
    public $house_number = null;
    public $room = null;
    public $guests_count = null;
    public $price = null;

    public function __construct($obj) {
        if ($obj) {
            $objArr = (array)$obj;
            $this->phone_number = $this->getV($objArr, 'phone_number');
            $this->object_name = $this->getV($objArr, 'object_name');
            $this->stars = $this->getV($objArr, 'stars');
            $this->host_name = $this->getV($objArr, 'host_name');
            $this->country = $this->getV($objArr, 'country');
            $this->city = $this->getV($objArr, 'city');
            $this->street = $this->getV($objArr, 'street');
            $this->house_number = $this->getV($objArr, 'house_number');
            $this->room = $this->getV($objArr, 'room');
            $this->guests_count = $this->getV($objArr, 'guests_count');
            $this->price = $this->getV($objArr, 'price');
        }
    }

    private function getV($obj, $prop) {
        return array_key_exists($prop, $obj) ? $obj[$prop] : null;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('phone_number', new Assert\Length(['min' => 1]));
        $metadata->addPropertyConstraint('phone_number', new Assert\NotNull());

        $metadata->addPropertyConstraint('object_name', new Assert\Length(['min' => 1]));
        $metadata->addPropertyConstraint('object_name', new Assert\NotNull());

        $metadata->addPropertyConstraint('stars', new Assert\PositiveOrZero());
        $metadata->addPropertyConstraint('stars', new Assert\NotNull());

        $metadata->addPropertyConstraint('host_name', new Assert\Length(['min' => 1]));
        $metadata->addPropertyConstraint('host_name', new Assert\NotNull());

        $metadata->addPropertyConstraint('country', new Assert\Length(['min' => 1]));
        $metadata->addPropertyConstraint('country', new Assert\NotNull());

        $metadata->addPropertyConstraint('city', new Assert\Length(['min' => 1]));
        $metadata->addPropertyConstraint('city', new Assert\NotNull());

        $metadata->addPropertyConstraint('street', new Assert\Length(['min' => 1]));
        $metadata->addPropertyConstraint('street', new Assert\NotNull());

        $metadata->addPropertyConstraint('house_number', new Assert\Positive());
        $metadata->addPropertyConstraint('house_number', new Assert\NotNull());

        $metadata->addPropertyConstraint('guests_count', new Assert\Positive());
        $metadata->addPropertyConstraint('guests_count', new Assert\NotNull());

        $metadata->addPropertyConstraint('price', new Assert\Positive());
        $metadata->addPropertyConstraint('price', new Assert\NotNull());

    }
}