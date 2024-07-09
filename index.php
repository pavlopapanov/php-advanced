<?php

class ValueObject
{
    private int $red;
    private int $green;
    private int $blue;

    public function __construct(int $red, int $green, int $blue)
    {
        $this->red = $red;
        $this->green = $green;
        $this->blue = $blue;
    }

    public function setRed(): int
    {
        if ($this->red < 0 || $this->red > 255) {
            throw new Exception("Red must be between 0 and 255");
        }

        return $this->red;
    }

    public function getRed(): int
    {
        return $this->red;
    }

    public function setGreen(): int
    {
        if ($this->green < 0 || $this->green > 255) {
            throw new Exception("Green must be between 0 and 255");
        }

        return $this->green;
    }

    public function getGreen(): int
    {
        return $this->green;
    }

    public function setBlue(): int
    {
        if ($this->blue < 0 || $this->blue > 255) {
            throw new Exception("Blue must be between 0 and 255");
        }

        return $this->blue;
    }

    public function getBlue(): int
    {
        return $this->setBlue();
    }

    public function equals($object): bool
    {
        if (get_class($this) !== get_class($object)) {
            return false;
        }

        $properties1 = get_object_vars($this);
        $properties2 = get_object_vars($object);

        foreach ($properties1 as $property => $value) {
            if (!array_key_exists($property, $properties2) || $properties2[$property] !== $value) {
                return false;
            }
        }

        return true;
    }

    public static function random(): ValueObject
    {
        $red = rand(0, 255);
        $green = rand(0, 255);
        $blue = rand(0, 255);

        return new ValueObject($red, $green, $blue);
    }

    public function __toString()
    {
        return "RGB({$this->red}, {$this->green}, {$this->blue})";
    }

    public function mix($color): ValueObject
    {
        $red = round(($this->red + $color->getRed()) / 2);
        $green = round(($this->green + $color->getGreen()) / 2);
        $blue = round(($this->blue + $color->getBlue()) / 2);

        return new ValueObject($red, $green, $blue);
    }
}

$colors = new ValueObject(200, 199, 25);
$colors1 = new ValueObject(230, 199, 25);

echo 'Equals method - ';
var_dump($colors->equals($colors1));
echo '<br>';

$randomColor = ValueObject::random();

echo 'Random color - ';
var_dump($randomColor);
echo '<br>';

echo 'Mix method - ';
$color = new ValueObject(250, 250, 250);
$mixedColor = $color->mix(new ValueObject(100, 100, 100));
echo 'red - ' . $mixedColor->getRed() . ', '; // 175
echo 'green - ' . $mixedColor->getGreen() . ', '; // 175
echo 'blue - ' . $mixedColor->getBlue(); // 175
