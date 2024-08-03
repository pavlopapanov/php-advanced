<?php

class Contact
{
    private string $name;
    private string $surname;
    private string $email;
    private string $phone;
    private string $address;

    public function __construct(ContactBuilder $builder)
    {
        $this->name = $builder->getName();
        $this->surname = $builder->getSurname();
        $this->email = $builder->getEmail();
        $this->phone = $builder->getPhone();
        $this->address = $builder->getAddress();
    }

    // getters for product details will go here
}

class ContactBuilder
{
    private string $name;
    private string $surname;
    private string $email;
    private string $phone;
    private string $address;

    public function name($name): ContactBuilder
    {
        $this->name = $name;
        return $this;
    }

    public function surname($surname): ContactBuilder
    {
        $this->surname = $surname;
        return $this;
    }

    public function email($email): ContactBuilder
    {
        $this->email = $email;
        return $this;
    }

    public function phone($phone): ContactBuilder
    {
        $this->phone = $phone;
        return $this;
    }

    public function address($address): ContactBuilder
    {
        $this->address = $address;
        return $this;
    }

    // getters will go here
    public function getName(): string
    {
        return $this->name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function build(): Contact
    {
        return new Contact($this);
    }
}

$productBuilder = new ContactBuilder();
$product = $productBuilder->phone('000-555-000')
    ->name('John')
    ->surname('Doe')
    ->email('johndoe@example.com')
    ->address('Address')
    ->build();