<?php

namespace Fishingboy\MaDump;

/**
 * Magento var_dump tool
 */
class MaDumpOutput
{
    const VAR_TYPE_BOOLEAN = "boolean";

    public static function text($data_schema)
    {
        $deep = 0;
        $output = "<pre>";
        $attributes = [];
        if ($data_schema['type'] == "object") {
            $output .= $data_schema['class'] . "\n";

            if (isset($data_schema['methods'])) {
                foreach ($data_schema['methods'] as $method => $method_info) {
                    $params = [];
                    foreach ($method_info['params'] as $param) {
                        $params[] = ($param['type'] !== '') ? "{$param['type']} \${$param['name']}" : "\${$param['name']}";
                    }
                    $method_output = self::getPadding($deep) . "->{$method}(" . implode(', ', $params) . ")";
                    $value = $method_info['value'];
                    if ($value !== null) {
                        $method_output .= " : " . (is_string($value) ? $value : self::dumpValue($value));
                    }
                    $attributes[] = $method_output;
                }
            }

            foreach ($data_schema['attributes'] as $key => $attribute) {
                if ($attribute['type'] == "object") {
                    $attributes[] = self::getPadding($deep) . "[$key] ({$attribute['class']})";
                } else if ($attribute['type'] == "array") {
                    $attributes[] = self::getPadding($deep) . "[$key] ({$attribute['value']})";
                } else {
                    $attributes[] = self::getPadding($deep) . "[$key] => " . self::dumpValue($attribute['value']);
                }
            }
        } else if ($data_schema['type'] == "array") {
            $count = count($data_schema['attributes']);
            $output .= "Array($count) => \n";
            $attributes = [];
            foreach ($data_schema['attributes'] as $key => $attribute) {
                if ($attribute['type'] == "object") {
//                    $value_output = "=> (" . get_class($value) . ")";
                } else if ($attribute['type'] == "array") {
//                    $value_output = "=> (Array)";
                } else {
                    $value_output = "=> " . self::dumpValue($attribute['value']);
                }
                $attributes[] = self::getPadding($deep) . "[{$key}] $value_output";
            }
        } else {
            $output .= self::dumpValue($data_schema['value']);
        }

        sort($attributes);
        $output .= implode("\n", $attributes);
        $output .= "</pre>";

        return $output;
    }

    public static function html($data_schema)
    {

    }


    private static function dumpValue($value)
    {
        $type = gettype($value);
        $value_output = $value;
        if ($type == self::VAR_TYPE_BOOLEAN) {
            $value_output = ($value) ? "true" : "false";
        }

        return "$value_output ($type)";
    }

    private static function getPadding($deep): string
    {
        return str_pad(" ", ($deep + 1) * 4);
    }
}