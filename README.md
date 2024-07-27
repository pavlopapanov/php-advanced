# Interface segregation

Відрефакторити приклад по принципу Interface segregation:

```php
interface Bird 
{
    public function eat();
    public function fly();
}

class Swallow implements Bird
{
    public function eat() { ... }
    public function fly() { ... }
}

class Ostrich implements Bird
{
    public function eat() { ... }
    public function fly() { /* exception */ }
}
```