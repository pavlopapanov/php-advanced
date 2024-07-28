# Dependency inversion 

Відрефакторити приклад по принципу Dependency inversion:

```php
<?php
class Mysql
{
    public function getData()
    {
        return 'some data from database';
    }
}

class Controller
{
    private $adapter;

    public function __construct(Mysql $mysql)
    {
        $this->adapter = $mysql;
    }

    function getData()
    {
        $this->adapter->getData();
    }
}
```