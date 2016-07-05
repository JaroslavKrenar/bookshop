<?php

/**
 *  @author Jaroslav Krenar
 */

class Staircase {

    /**
     * Symbol used to draw a staircase
     * 
     * @var string 
     */
    public $symbol = '#';

    /**
     * Parts of staircase
     * 
     * @var array
     */
    protected $parts = [];

    /**
     * Creates staircase parts by height
     * 
     * @param integer $height height of the staircase
     */
    public function __construct($height)
    {
        $symbolCount = $spaceCount = (int) $height;

        while ($spaceCount--) {
            $this->parts[] = str_repeat(' ', $spaceCount) . str_repeat($this->symbol, $symbolCount - $spaceCount);
        }
    }

    /**
     * Draws a staircase.
     * 
     * @return void
     */
    public function drawStaircase()
    {
        echo implode(PHP_EOL, $this->parts) . PHP_EOL;
    }

    /**
     * Draws a staircase in right direction.
     * 
     * @return void
     */
    public function drawRightStaircase()
    {
        echo implode(PHP_EOL, array_map('strrev', $this->parts)) . PHP_EOL;
    }

    /**
     * Draws a pyramid staircase. Just for fun :)
     * 
     * @return void
     */
    public function drawPyramidStaircase()
    {
        echo implode(PHP_EOL, array_map(function($part) {
                    return $part . strrev($part);
                }, $this->parts)) . PHP_EOL;
    }
}

$obj = new Staircase(6);
$obj->drawStaircase();
