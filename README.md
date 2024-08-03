# Contact Class

Зробіть рефакторинг коду:

```php
class Contact {
    private $name;
    private $surname;
    private $email;
    private $phone;
    private $address;
    
    public function __construct($name, $surname, $email, $phone, $address)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->phone = $phone;
        $this->address = $address;
    }
}
```

Так щоб нові об'єкти можна було б створювати таки способом:

```php
$contact = new Contact();
$newContact = $contact->phone('000-555-000')
    ->name("John")
    ->surname("Surname")
    ->email("john@email.com")
    ->address("Some address")
    ->build();
```