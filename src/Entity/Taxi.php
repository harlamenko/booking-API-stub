<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TaxiRepository")
 */
class Taxi implements \JsonSerializable
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sits;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $luggage;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $service;
    /**
     * @ORM\Column(type="boolean")
     */
    private $meeting = false;
    /**
     * @ORM\Column(type="integer")
     */
    private $price = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getSits(): ?string
    {
        return $this->sits;
    }

    public function setSits(?string $sits): self
    {
        $this->sits = $sits;

        return $this;
    }

    public function getLuggage(): ?string
    {
        return $this->luggage;
    }

    public function setLuggage(?string $luggage): self
    {
        $this->luggage = $luggage;

        return $this;
    }

    public function getService(): ?string
    {
        return $this->service;
    }

    public function setService(?string $service): self
    {
        $this->service = $service;

        return $this;
    }

    public function getMeeting(): ?bool
    {
        return $this->meeting;
    }

    public function setMeeting($meeting): self
    {
        $this->meeting = $meeting;

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
    
    public function __construct() { }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'type' => $this->getType(),
            'sits' => $this->getSits(),
            'luggage' => $this->getLuggage(),
            'service' => $this->getService(),
            'meeting' => $this->getMeeting(),
            'price' => $this->getPrice(),
        ];
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
