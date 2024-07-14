<?php

namespace Classes;

class User
{
    private string $name;
    private int $age;
    private string $email;

    public function __call(string $method, array $arguments)
    {
        if (method_exists($this, $method)) {
            call_user_func_array([$this, $method], $arguments);
        } else {
            throw new CustomException("Method $method does not exist");
        }
    }

    private function setName($name)
    {
        return $this->name = $name;
    }

    private function setAge($age)
    {
        return $this->age = $age;
    }

    private function setEmail($email)
    {
        return $this->email = $email;
    }

    public function getAll(): array
    {
        return [
            'name' => $this->name,
            'age' => $this->age,
            'email' => $this->email
        ];
    }
}