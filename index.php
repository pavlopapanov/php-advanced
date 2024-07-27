<?php

interface FormatterInterface
{
    public function formater($string);
}

class RawFormatter implements FormatterInterface
{
    public function formater($string)
    {
        return $string;
    }
}

class WithDateFormatter implements FormatterInterface
{
    public function formater($string)
    {
        return date('Y-m-d H:i:s') . $string;
    }
}

class WithDateAndDetailsFormatter implements FormatterInterface
{
    public function formater($string)
    {
        return date('Y-m-d H:i:s') . $string . ' - With some details';
    }
}

interface DeliveryInterface
{
    public function deliver($message);
}

class DeliverByEmail implements DeliveryInterface
{
    public function deliver($message)
    {
        echo "Output format ({$message}) by email";
    }
}

class DeliverBySMS implements DeliveryInterface
{
    public function deliver($message)
    {
        echo "Output format ({$message}) by sms";
    }
}

class DeliverByConsole implements DeliveryInterface
{
    public function deliver($message)
    {
        echo "Output format ({$message}) by console";
    }
}

class Logger
{
    private $format;
    private $delivery;

    public function __construct(FormatterInterface $format, DeliveryInterface $delivery)
    {
        $this->format = $format;
        $this->delivery = $delivery;
    }

    public function log($string)
    {
        $formatedString = $this->format->formater($string);
        $this->delivery->deliver($formatedString);
    }
}

$format = new RawFormatter();
$delivery = new DeliverBySMS();
$logger = new Logger($format, $delivery);
$logger->log('Emergency error! Please fix me!');
