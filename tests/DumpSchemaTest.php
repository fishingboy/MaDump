<?php

use Fishingboy\MaDump\MaDump;
use Fishingboy\MaDump\MaDumpSchema;
use PHPUnit\Framework\TestCase;

class DumpSchemaTest extends TestCase
{
    public function test_dump_value_int()
    {
        $data = 1;
        $response = MaDumpSchema::getSchema($data);
        $this->assertEquals(["type" => "value", "value" => 1], $response);
    }

    public function test_dump_value_bool()
    {
        $data = true;
        $response = MaDumpSchema::getSchema($data);
        $this->assertEquals(["type" => "value", "value" => true], $response);
    }

    public function test_dump_array()
    {
        $data = [1];
        $response = MaDumpSchema::getSchema($data);
        $this->assertEquals([
            "type" => "array",
            "attributes" => [
                ["type" => "value", "value" => 1]
            ]
        ], $response);
    }

    public function test_dump_object()
    {
        $object = (object) ["a" => 1];
        $response = MaDumpSchema::getSchema($object);
        $this->assertEquals([
            "type" => "object",
            "class" => "stdClass",
            "attributes" => [
                "a" => ["type" => "value", "value" => 1]
            ]
        ], $response);
    }

    public function test_dump_object2()
    {
        $object = new Car();
        $response = MaDumpSchema::getSchema($object);
        echo "<pre>response = " . print_r($response, true) . "</pre>\n";
//        echo $response;
        $this->assertEquals([
            "type" => "object",
            "class" => "Car",
            "attributes" => [
                "attrs" => ["type" => "array", "value" => "Key Value Array"],
                "length" => ["type" => "value", "value" => 1],
                "items" => ["type" => "array", "value" => "Array"],
                "light" => ["type" => "object", "class" => "Light"],
            ],
            "methods" => [
                "__construct" => ["method" => "__construct", "params" => [], "value" => null],
                "getLength" => ["method" => "getLength", "params" => [], "value" => 1],
                "getLight" => ["method" => "getLight", "params" => [], "value" => "Light"],
                "getLight2" => ["method" => "getLight2", "params" => [["type" => "bool", "name" => "flag"], ["type" => "int", "name" => "on"]], "value" => null],
            ],
        ], $response);
    }
}