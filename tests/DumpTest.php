<?php

use Fishingboy\MaDump\MaDump;
use PHPUnit\Framework\TestCase;


class DumpTest extends TestCase
{
    public function test_dump_value_int()
    {
        $data = 1;
        $response = MaDump::dump($data, true);
        $this->assertEquals("<pre>1 (integer)</pre>", $response);
    }

    public function test_dump_value_bool()
    {
        $data = true;
        $dump = new MaDump();
        $response = MaDump::dump($data, true);;
        $this->assertEquals("<pre>true (boolean)</pre>", $response);
    }

    public function test_dump_array()
    {
        $data = [1];
        var_dump($data);
        $response = MaDump::dump($data, true);
        $this->assertEquals("<pre>Array(1) => \n    [0] => 1 (integer)</pre>", $response);
    }

    public function test_dump_object()
    {
        $object = (object) ["a" => 1];
        $response = MaDump::dump($object, true);
        echo $response;
        $this->assertEquals("<pre>stdClass
    [a] => 1 (integer)</pre>", $response);
    }

    public function test_dump_object2()
    {
        $object = new Car();
        $response = MaDump::dump($object, true);
        echo $response;
        $this->assertEquals("<pre>Car
    ->__construct()
    ->getLength() : 1 (integer)
    ->getLight() : Light
    ->getLight2(bool \$flag, int \$on)
    [attrs] (Key Value Array)
    [items] (Array)
    [length] => 1 (integer)
    [light] (Light)</pre>", $response);
    }
}