<?php

namespace DB1;

interface MemorySlotAddress
{
    public function getRow(): UnsignedInteger;
    public function getColumn(): UnsignedInteger;
}