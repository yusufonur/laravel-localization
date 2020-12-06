<?php


namespace YusufOnur\LaravelLocalization\Support\DataTransferObject;


use ReflectionClass;
use ReflectionProperty;

class DataTransferObject
{
    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    public function toArray(): array
    {
        $reflect = new ReflectionClass($this);

        $result = [];

        foreach ($reflect->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            $result[$property->getName()] = $this->{$property->getName()};
        }

        return $result;
    }
}
