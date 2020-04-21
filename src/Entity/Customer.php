<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Table(name="customers")
 * @ORM\Entity(repositoryClass="App\Repository\CustomerRepository")
 */
class Customer
{

    use TimestampableEntity;

    /**
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=80)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(type="string", length=80)
     */
    private $surname;

    /**
     * @var string
     * @ORM\Column(type="string", length=80)
     */

    /**
     * @var string
     * @ORM\Column(type="string", length=120, unique=true)
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(type="string", length=40)
     */
    private $mobile;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Customer
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getSurname(): ?string
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     * @return Customer
     */
    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return Customer
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    /**
     * @param string $mobile
     * @return Customer
     */
    public function setMobile(string $mobile): self
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * @return string
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param string $address
     * @return Customer
     */
    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

}
