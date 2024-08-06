<?php

class ContactBuilder
{
    private string $name;
    private string $surname;
    private string $email;
    private string $phone;
    private string $address;

    public function name(string $name): ContactBuilder
    {
        $this->name = $name;
        return $this;
    }

    public function surname(string $surname): ContactBuilder
    {
        $this->surname = $surname;
        return $this;
    }

    public function email(string $email): ContactBuilder
    {
        $this->email = $email;
        return $this;
    }

    public function phone(string $phone): ContactBuilder
    {
        $this->phone = $phone;
        return $this;
    }

    public function address(string $address): ContactBuilder
    {
        $this->address = $address;
        return $this;
    }

    public function build(): array
    {
        return [
            'name' => $this->name,
            'surname' => $this->surname,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address
        ];
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
}

$contactBuilder = new ContactBuilder();
$contact = $contactBuilder
    ->name('John')
    ->surname('Doe')
    ->email('johndoe@example.com')
    ->phone('000-555-000')
    ->address('Address')
    ->build();