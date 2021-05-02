<?php

namespace DB1;

use DB1\MemorySlotAddress;

class MemoryAddress implements MemorySlotAddress
{
    private int $row;
    private int $column;
    private string $value;

    public function __construct(int $row, int $column)
    {
        $this->row = $row;
        $this->column = $column;
        $this->value = "0";
    }

    public function getRow(): UnsignedInteger
    {
        return new UnsignedInteger($this->row - 1);
    }

    public function getColumn(): UnsignedInteger
    {
        return new UnsignedInteger($this->column - 1);
    }

    public function getValue(): string
    {
        return $this->value;
    }
}