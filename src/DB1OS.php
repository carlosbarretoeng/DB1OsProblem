<?php

declare(strict_types=1);

namespace DB1;

class DB1OS
{
    private function getElementInMemorySlot(MemorySlotAddress $memorySlotAddress, array $memoryPool): string
    {
        $row = $memorySlotAddress->getRow()->toArrayIndex();
        $column = $memorySlotAddress->getColumn()->toArrayIndex();
        return "" . $memoryPool[$row][$column];
    }

    private function createSearchPool($memoryPool) : array
    {
        $searchedPool = [];
        $totalRows = count($memoryPool);
        $totalColums = count($memoryPool[0]);
        for($i = 0; $i < $totalRows; $i++){
            for($j = 0; $j < $totalColums; $j++){
                $searchedPool[$i][$j] = 0;
            }
        }
        return $searchedPool;
    }

    private function replaceAdjacentElements(
        string $elementToFind,
        string $elementToReplace,
        MemorySlotAddress $slotAddress,
        array $memoryPool,
        array $searchedPool = []
    ): array
    {
        if (empty($searchedPool)) {
            $searchedPool = $this->createSearchPool($memoryPool);
        }

        $row = $slotAddress->getRow()->toArrayIndex();
        $column = $slotAddress->getColumn()->toArrayIndex();

        if (
            $searchedPool[$row][$column] ||
            $row < 0 ||
            $row > count($memoryPool) ||
            $column < 0 ||
            $column > count($memoryPool[0]) ||
            $memoryPool[$row][$column] !== $elementToFind
        ) {
            return $memoryPool;
        }

        $searchedPool[$row][$column] = 1;

        $memoryPool[$row][$column] = $elementToReplace;

        $searchInTop = true;
        $searchInLeft = true;
        $searchInRight = true;
        $searchInDown = true;

        if ($row === 0) {
            $searchInTop = false;
        }

        if ($row === (count($memoryPool) - 1)) {
            $searchInDown = false;
        }

        if ($column === 0) {
            $searchInLeft = false;
        }
        if ($column === (count($memoryPool[$row]) - 1)) {
            $searchInRight = false;
        }

        if ($searchInLeft) {
            $memoryPool = $this->replaceAdjacentElements(
                $elementToFind,
                $elementToReplace,
                new MemoryAddress($row + 1, $column),
                $memoryPool,
                $searchedPool
            );
        }

        if ($searchInDown) {
            $memoryPool = $this->replaceAdjacentElements(
                $elementToFind,
                $elementToReplace,
                new MemoryAddress($row + 2, $column + 1),
                $memoryPool,
                $searchedPool
            );
        }


        if ($searchInRight) {
            $memoryPool = $this->replaceAdjacentElements(
                $elementToFind,
                $elementToReplace,
                new MemoryAddress($row + 1, $column + 2),
                $memoryPool,
                $searchedPool
            );
        }

        if ($searchInTop) {
            $memoryPool = $this->replaceAdjacentElements(
                $elementToFind,
                $elementToReplace,
                new MemoryAddress($row, $column + 1),
                $memoryPool,
                $searchedPool
            );
        }

        return $memoryPool;
    }

    public function allocatePIDAtMemorySlotAddress(
        string $processPID,
        MemorySlotAddress $memorySlotAddress,
        array $memoryPool
    ): MemoryPool
    {
        $elementPIDOrZero = $this->getElementInMemorySlot($memorySlotAddress, $memoryPool);
        $newMemoryPool = $this->replaceAdjacentElements($elementPIDOrZero, $processPID, $memorySlotAddress, $memoryPool);
        return new MemoryPool($newMemoryPool);
    }
}