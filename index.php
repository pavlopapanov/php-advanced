<?php

interface Flyable
{
    public function fly();
}

interface Eatable
{
    public function eat();
}

class Swallow implements Flyable, Eatable
{
    public function eat() { ... }
    public function fly() { ... }
}

class Ostrich implements Eatable
{
    public function eat() { ... }
}
