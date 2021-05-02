<?php

namespace DB1;

use phpDocumentor\Reflection\Types\Integer;

class UnsignedInteger
{
    private $value;

    /**
     * UnsignedInteger constructor.
     * @param $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    public function toArrayIndex() : int{
        return $this->value;
    }
}