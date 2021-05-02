<?php

declare(strict_types=1);

use DB1\DB1OS;
use DB1\MemoryAddress;
use DB1\MemoryPool;
use PHPUnit\Framework\TestCase;

class MemoryAllocationTest extends TestCase
{
    protected $db1os;
    protected $memoryPool;

    protected function setUp(): void
    {
        $this->db1os = new DB1OS();
        $this->memoryPool = [
            ["A", "0", "0", "0"],
            ["A", "A", "0", "B"],
            ["0", "0", "0", "B"],
            ["C", "0", "C", "0"],
        ];
    }

    public function testExemple1(): void
    {
        $processPID = "D";
        $memorySlotAddress = new MemoryAddress(2, 4);
        $expected = new MemoryPool(array(
            ["A", "0", "0", "0"],
            ["A", "A", "0", "D"],
            ["0", "0", "0", "D"],
            ["C", "0", "C", "0"],
        ));

        $result = $this->db1os->allocatePIDAtMemorySlotAddress($processPID, $memorySlotAddress, $this->memoryPool);

        $this->assertEquals($expected, $result);
    }

    public function testExemple2(): void
    {
        $processPID = "B";
        $memorySlotAddress = new MemoryAddress(2, 4);
        $expected = new MemoryPool(array(
            ["A", "0", "0", "0"],
            ["A", "A", "0", "B"],
            ["0", "0", "0", "B"],
            ["C", "0", "C", "0"],
        ));

        $result = $this->db1os->allocatePIDAtMemorySlotAddress($processPID, $memorySlotAddress, $this->memoryPool);

        $this->assertEquals($expected, $result);
    }

    public function testExemple3(): void
    {
        $processPID = "D";
        $memorySlotAddress = new MemoryAddress(4, 1);
        $expected = new MemoryPool(array(
            ["A", "0", "0", "0"],
            ["A", "A", "0", "B"],
            ["0", "0", "0", "B"],
            ["D", "0", "C", "0"],
        ));

        $result = $this->db1os->allocatePIDAtMemorySlotAddress($processPID, $memorySlotAddress, $this->memoryPool);

        $this->assertEquals($expected, $result);
    }

    public function testExemple4(): void
    {
        $processPID = "D";
        $memorySlotAddress = new MemoryAddress(1, 3);
        $expected = new MemoryPool(array(
            ["A", "D", "D", "D"],
            ["A", "A", "D", "B"],
            ["D", "D", "D", "B"],
            ["C", "D", "C", "0"],
        ));

        $result = $this->db1os->allocatePIDAtMemorySlotAddress($processPID, $memorySlotAddress, $this->memoryPool);
        $this->assertEquals($expected, $result);
    }

    public function testExempleAllAllocated(): void
    {
        $processPID = "B";
        $memorySlotAddress = new MemoryAddress(1, 1);
        $memory = array(
            ["A", "A", "A", "A"],
            ["A", "A", "A", "A"],
            ["A", "A", "A", "A"],
            ["A", "A", "A", "A"],
        );
        $expected = new MemoryPool(array(
            ["B", "B", "B", "B"],
            ["B", "B", "B", "B"],
            ["B", "B", "B", "B"],
            ["B", "B", "B", "B"],
        ));

        $result = $this->db1os->allocatePIDAtMemorySlotAddress($processPID, $memorySlotAddress, $memory);
        $this->assertEquals($expected, $result);
    }

    public function testExempleOnlyFirstAllocated(): void
    {
        $processPID = "B";
        $memorySlotAddress = new MemoryAddress(1, 1);
        $memory = array(
            ["A", "0", "0", "0"],
            ["0", "0", "0", "0"],
            ["0", "0", "0", "0"],
            ["0", "0", "0", "0"],
        );
        $expected = new MemoryPool(array(
            ["B", "0", "0", "0"],
            ["0", "0", "0", "0"],
            ["0", "0", "0", "0"],
            ["0", "0", "0", "0"],
        ));

        $result = $this->db1os->allocatePIDAtMemorySlotAddress($processPID, $memorySlotAddress, $memory);
        $this->assertEquals($expected, $result);
    }

    public function testExempleOnlyFirstAllocated2(): void
    {
        $processPID = "B";
        $memorySlotAddress = new MemoryAddress(1, 2);
        $memory = array(
            ["A", "0", "0", "0"],
            ["0", "0", "0", "0"],
            ["0", "0", "0", "0"],
            ["0", "0", "0", "0"],
        );
        $expected = new MemoryPool(array(
            ["A", "B", "B", "B"],
            ["B", "B", "B", "B"],
            ["B", "B", "B", "B"],
            ["B", "B", "B", "B"],
        ));

        $result = $this->db1os->allocatePIDAtMemorySlotAddress($processPID, $memorySlotAddress, $memory);
        $this->assertEquals($expected, $result);
    }

    public function testExempleChessboard(): void
    {
        $processPID = "B";
        $memorySlotAddress = new MemoryAddress(1, 2);
        $memory = array(
            ["A", "0", "A", "0"],
            ["0", "A", "0", "A"],
            ["A", "0", "A", "0"],
            ["0", "A", "0", "A"],
        );
        $expected = new MemoryPool(array(
            ["A", "B", "A", "0"],
            ["0", "A", "0", "A"],
            ["A", "0", "A", "0"],
            ["0", "A", "0", "A"],
        ));

        $result = $this->db1os->allocatePIDAtMemorySlotAddress($processPID, $memorySlotAddress, $memory);
        $this->assertEquals($expected, $result);
    }
}