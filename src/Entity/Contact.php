<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass=ContactRepository::class)
 */
class Contact
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message = "First name cannot be empty")
     * @ORM\Column(type="string", length=50)
     */
    private $firstName;

    /**
     * @Assert\NotBlank(message = "Last name cannot be empty")
     * @ORM\Column(type="string", length=50)
     */
    private $lastName;

    /**
     * @Assert\NotBlank(message = "Street name cannot be empty")
     * @ORM\Column(type="string", length=255)
     */
    private $streetName;

    /**
     * @Assert\NotBlank(message = "Street number cannot be empty")
     * @ORM\Column(type="string", length=10)
     */
    private $streetNumber;

    /**
     * @Assert\NotBlank(message = "Zip cannot be empty")
     * @ORM\Column(type="string", length=20)
     */
    private $zip;

    /**
     * @Assert\NotBlank(message = "City cannot be empty")
     * @ORM\Column(type="string", length=50)
     */
    private $city;

    /**
     * @Assert\NotBlank(message = "No country selected")
     * @Assert\Country(message = "The selected country code {{ value }} is not valid")
     * @ORM\Column(type="string", length=2)
     */
    private $country;

    /**
     * @Assert\NotBlank(message = "Phone number cannot be empty")
     * @ORM\Column(type="string", length=20)
     */
    private $phoneNumber;

    /**
     * @Assert\NotBlank(message = "Date of Birth cannot be empty")
     * @Assert\Date(message = "S{{value}} is not a valid date")
     * @ORM\Column(type="date")
     */
    private $birthDay;

    /**
     * @Assert\NotBlank(message = "Email address cannot be empty")
     * * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email address."
     * )
     * @ORM\Column(type="string", length=255)
     */
    private $emailAddress;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getStreetName(): ?string
    {
        return $this->streetName;
    }

    public function setStreetName(string $streetName): self
    {
        $this->streetName = $streetName;

        return $this;
    }

    public function getStreetNumber(): ?string
    {
        return $this->streetNumber;
    }

    public function setStreetNumber(string $streetNumber): self
    {
        $this->streetNumber = $streetNumber;

        return $this;
    }

    public function getZip(): ?string
    {
        return $this->zip;
    }

    public function setZip(string $zip): self
    {
        $this->zip = $zip;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getBirthDay(): ?\DateTimeInterface
    {
        return $this->birthDay;
    }

    public function setBirthDay(?\DateTimeInterface $birthDay): self
    {
        $this->birthDay = $birthDay;

        return $this;
    }

    public function getEmailAddress(): ?string
    {
        return $this->emailAddress;
    }

    public function setEmailAddress(string $emailAddress): self
    {
        $this->emailAddress = $emailAddress;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }
}