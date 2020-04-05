<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=25, unique=true)
     */
    public $username = '';
    /**
     * @ORM\Column(type="string", length=255)
     */
    public $password = '';

    public function __construct($username) {
        $this->username = $username;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
    public function getSalt()
    {
     return null;
    }
    public function getRoles()
    {
     return array('ROLE_USER');
    }
    public function eraseCredentials()
    {
    }
   
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('username', new Assert\Length(['min' => 1]));
        $metadata->addPropertyConstraint('username', new Assert\NotNull());
        
        $metadata->addPropertyConstraint('password', new Assert\Length(['min' => 1]));
        $metadata->addPropertyConstraint('password', new Assert\NotNull());
    }
    
}