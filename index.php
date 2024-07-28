<?php

interface Taxi
{
    public function getModel();

    public function getPrice();
}

class EconomTaxi implements Taxi
{
    public function getModel(): string
    {
        return "Economy Model";
    }

    public function getPrice(): int
    {
        return 100;
    }
}

class StandardTaxi implements Taxi
{
    public function getModel(): string
    {
        return "Standard Model";
    }

    public function getPrice(): int
    {
        return 200;
    }
}

class LuxTaxi implements Taxi
{
    public function getModel(): string
    {
        return "Lux Model";
    }

    public function getPrice(): int
    {
        return 300;
    }
}

interface TaxiFactory
{
    public function createTaxi();
}

class EconomTaxFactory implements TaxiFactory
{
    public function createTaxi()
    {
        return new EconomTaxi();
    }
}

class StandardTaxFactory implements TaxiFactory
{
    public function createTaxi()
    {
        return new StandardTaxi();
    }
}

class LuxTaxFactory implements TaxiFactory
{
    public function createTaxi()
    {
        return new LuxTaxi();
    }
}

function clientCode(TaxiFactory $factory)
{
    $taxi = $factory->createTaxi();
    echo "Model: " . $taxi - getModel() . "<br>";
    echo "Price: " . $taxi->getPrice() . "<br>";
}

echo "Taxi Economy: ";
clientCode(new EconomTaxi());

echo "Taxi Standard: ";
clientCode(new StandardTaxi());

echo "Taxi Lux: ";
clientCode(new LuxTaxi());