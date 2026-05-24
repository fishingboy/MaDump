# MaDump

[![Tests](https://github.com/fishingboy/MaDump/actions/workflows/tests.yml/badge.svg)](https://github.com/fishingboy/MaDump/actions/workflows/tests.yml)
[![Packagist Version](https://img.shields.io/packagist/v/fishingboy/madump.svg)](https://packagist.org/packages/fishingboy/madump)
[![Downloads](https://img.shields.io/packagist/dt/fishingboy/madump.svg?label=Downloads)](https://packagist.org/packages/fishingboy/madump)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](LICENSE)

English | [繁體中文](README-zh.md)

## Why MaDump?

Calling `var_dump()` or `print_r()` on a Magento object causes an out-of-memory error because of deeply nested circular references. MaDump dumps only the first level of an object, giving you just enough information to navigate the code during development.

## Installation
```bash
composer require fishingboy/madump
```

## Usage

1. Print directly
    ```php
    use Fishingboy\MaDump\MaDump;
    MaDump::dump($product);
    ```

   Output:
    ```html
    <pre>
    Magento\Catalog\Model\Product\Interceptor
        ->addAttributeUpdate($code, $value, $store)
        ->addCustomOption($code, $value, $product)
        ->addData(array $arr)
        ->addImageToMediaGallery($file, $mediaAttribute, $move, $exclude)
        ->addOption(Magento\Catalog\Model\Product\Option $option)
        ->afterCommitCallback()
        ->afterDelete()
        ->afterDeleteCommit()
        ->formatUrlKey($str)
        ->fromArray(array $data)
        ->getAttributeDefaultValue($attributeCode)
        ->getAttributeSetId() : 16 (string)
        ->getAttributeText($attributeCode)
        ->getAttributes($groupId, $skipSuper)
        ->getAvailableInCategories() : array
        ->getCacheIdTags() : array
        ->getCacheTags() : array
        ->getCalculatedFinalPrice() :  (NULL)
        ->getCategory() :  (NULL)
        ->getCategoryCollection() : Magento\Catalog\Model\ResourceModel\Category\Collection\Interceptor
        ...
    </pre>
    ```

2. Capture as a string (for logging)
    ```php
    use Fishingboy\MaDump\MaDump;
    $product_dump = MaDump::dump($product, true);
    $this->_logger->info("product => " . $product_dump);
    ```

3. Stop execution after dumping
    ```php
    use Fishingboy\MaDump\MaDump;
    MaDump::dump($product);
    exit;
    ```

4. Typical trace workflow

    Step 1 — dump the top-level object:
    ```php
    MaDump::dump($product);
    ```

    Step 2 — drill into an attribute:
    ```php
    MaDump::dump($product->getCustomAttributes());
    ```

    Step 3 — drill further:
    ```php
    MaDump::dump($product->getCustomAttributes()[0]);
    ```

    Keep going level by level until you find what you need.

## Output Format

1. Object
    ```html
    <pre>
    Magento\Catalog\Model\Product\Interceptor
        ->addAttributeUpdate($code, $value, $store)
        ->addCustomOption($code, $value, $product)
        ->addData(array $arr)
        ->addImageToMediaGallery($file, $mediaAttribute, $move, $exclude)
        ->addOption(Magento\Catalog\Model\Product\Option $option)
        ->afterCommitCallback()
        ->afterDelete()
        ->afterDeleteCommit()
        ->formatUrlKey($str)
        ->fromArray(array $data)
        ->getAttributeDefaultValue($attributeCode)
        ->getAttributeSetId() : 16 (string)
        ->getAttributeText($attributeCode)
        ->getAttributes($groupId, $skipSuper)
        ->getAvailableInCategories() : array
        ->getCacheIdTags() : array
        ->getCacheTags() : array
        ->getCalculatedFinalPrice() :  (NULL)
        ->getCategory() :  (NULL)
        ->getCategoryCollection() : Magento\Catalog\Model\ResourceModel\Category\Collection\Interceptor
        ...
    </pre>
    ```

    Zero-argument getter methods are called automatically and their return values are shown inline:
    ```html
        ->getAttributeSetId() : 16 (string)
        ->getCategoryCollection() : Magento\Catalog\Model\ResourceModel\Category\Collection\Interceptor
        ->getCacheIdTags() : array
    ```

2. Array
    ```html
    <pre>
    Array(52) =>
    [0] => (Magento\Framework\Api\AttributeValue)
    [10] => (Magento\Framework\Api\AttributeValue)
    [11] => (Magento\Framework\Api\AttributeValue)
    [12] => (Magento\Framework\Api\AttributeValue)
    ...
    </pre>
    ```

    Or for a simple array:
    ```html
    <pre>
    Array(2) =>
    [0] => 101
    [1] => 102
    </pre>
    ```

3. Scalar value
    ```html
    <pre>1 (integer)</pre>
    ```

    ```html
    <pre>true (boolean)</pre>
    ```

    ```html
    <pre>sku-123 (string)</pre>
    ```

## License

This project is licensed under the [MIT License](LICENSE).
