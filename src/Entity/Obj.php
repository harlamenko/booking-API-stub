<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ObjRepository")
 */
class Obj implements \JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone_number = '';
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $object_name = '';
    /**
     * @ORM\Column(type="integer")
     */
    private $stars = 0;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $host_name = '';
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $country = '';
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city = '';
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $street = '';
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $house_number = null;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $room = null;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $guests_count = null;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $price = null;
    

    public function __construct() { }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(?string $phone_number): self
    {
        $this->phone_number = $phone_number;

        return $this;
    }
    
    public function getObjectName(): ?string
    {
        return $this->object_name;
    }

    public function setObjectName(?string $object_name): self
    {
        $this->object_name = $object_name;

        return $this;
    }
    
    public function getHostName(): ?string
    {
        return $this->host_name;
    }

    public function setHostName(?string $host_name): self
    {
        $this->host_name = $host_name;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(?string $street): self
    {
        $this->street = $street;

        return $this;
    }
    
    public function getStars(): ?int
    {
        return $this->stars;
    }

    public function setStars(?int $stars): self
    {
        $this->stars = $stars;

        return $this;
    }

    public function getRoom(): ?int
    {
        return $this->room;
    }

    public function setRoom(?int $room): self
    {
        $this->room = $room;

        return $this;
    }

    public function getGuestsCount(): ?int
    {
        return $this->guests_count;
    }

    public function setGuestsCount(?int $guests_count): self
    {
        $this->guests_count = $guests_count;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): self
    {
        $this->price = $price;

        return $this;
    }
    
    public function getHouseNumber(): ?int
    {
        return $this->house_number;
    }

    public function setHouseNumber(?int $house_number): self
    {
        $this->house_number = $house_number;

        return $this;
    }
    
    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'phone_number' => $this->getPhoneNumber(),
            'object_name' => $this->getObjectName(),
            'host_name' => $this->getHostName(),
            'country' => $this->getCountry(),
            'city' => $this->getCity(),
            'street' => $this->getStreet(),
            'stars' => $this->getStars(),
            'room' => $this->getRoom(),
            'guests_count' => $this->getGuestsCount(),
            'price' => $this->getPrice(),
            'house_number' => $this->getHouseNumber(),
        ];
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