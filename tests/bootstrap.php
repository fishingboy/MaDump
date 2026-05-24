<?php

require_once __DIR__ . '/../vendor/autoload.php';

class Car {
    public $length = 1;

    public $items = [1, 2, 3, 4];

    public $attrs = [
        "name" => "innova",
        "age" => 20,
    ];

    public $light;

    public function __construct()
    {
        $this->light = new Light();
    }

    public function getLength(): int
    {
        return $this->length;
    }

    public function getLight(): Light
    {
        return $this->light;
    }

    public function getLight2(bool $flag, int $on): Light
    {
        return $this->light;
    }

    private function getPrivateName(): string
    {
        return "MaDerDump";
    }
}

class Light {
    public $power = true;

    public function TurnOn()
    {
        $this->power = true;
    }

    public function TurnOff()
    {
        $this->power = false;
    }
}
