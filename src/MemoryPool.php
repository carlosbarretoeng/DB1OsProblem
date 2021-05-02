<?php

namespace DB1;

class MemoryPool
{
    private $memoryPool = array();

    public function __construct(array $memory)
    {
        foreach ($memory as $block) {
            $row = count($this->memoryPool);
            $this->memoryPool[$row] = array();
            foreach ($block as $item) {
                $this->memoryPool[$row][] = $item;
            }
        }
    }

    public function printMemory(){
        foreach ($this->memoryPool as $line) {
            foreach ($line as $item) {
                echo "". $item . "\t";
            }
            echo "\n";
        }
    }
}