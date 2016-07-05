<?php

/**
 *  @author Jaroslav Krenar
 */

class ConvertClass {

    /**
     * 2D array
     * 
     * @var array 
     */
    public $data = [];

    /**
     * Hourglass pattern. "x" represents a portion shape of hourglass.
     * 
     * @var array 
     */
    protected $hourglassPattern = ['x', 'x', 'x', '', 'x', '', 'x', 'x', 'x'];

    /**
     * Content of loaded file where each line is stored in array.
     * 
     * @var array 
     */
    protected $fileDataLines = [];

    /**
     * Extracted hourglasses
     * 
     * @var array 
     */
    protected $hourglasses = [];

    /**
     * Hourglass vector size
     * 
     * @var integer 
     */
    private $hourglassSize;

    /**
     * Reads file content
     * 
     * @param string $filePath
     * @throws Exception
     */
    public function __construct($filePath)
    {
        if (FALSE === $this->fileDataLines = file($filePath)) {
            throw new Exception('Unable to read file "' . $filePath . '"');
        }

        $this->hourglassSize = pow(count($this->hourglassPattern), 1 / 2); // square root of hourglass pattern vector
    }

    /**
     * Extract all hourglasses from file and store to $hourglasses
     * 
     * @return void
     */
    protected function extractHourglasses()
    {
        if (empty($this->data)) {
            $this->build2DArray();
        }

        // avoid multiple processsing if hourglasses already extracted
        if (!empty($this->hourglasses)) {
            return;
        }

        for ($y = 0; $y < $count = count($this->data) - $this->hourglassSize + 1; $y++) {
            for ($x = 0; $x < $count; $x++) {
                $this->hourglasses[] = $this->getHourglassAtPosition($y, $x);

                // code above can be replaced with the hardcoded version below (with better performance) without using hourglass pattern
                
                /*$this->hourglasses[] = [$this->data[$y][$x], $this->data[$y][$x + 1], $this->data[$y][$x + 2], $this->data[$y + 1][$x + 1], $this->data[$y + 2][$x], $this->data[$y + 2][$x + 1], $this->data[$y + 2][$x + 2]];*/
            }
        }
    }

    /**
     * Get hourglass from $data at defined row and col.
     * 
     * @param int $row
     * @param int $col
     * @return array hourglass values
     */
    private function getHourglassAtPosition($row, $col)
    {
        $hourglass = [];

        $index = 0;
        for ($y = 0; $y < $this->hourglassSize; $y++) {
            for ($x = 0; $x < $this->hourglassSize; $x++) {

                // if pattern matches add value to hourglass
                if ($this->hourglassPattern[$index] === 'x') {
                    $hourglass[] = $this->data[$row + $y][$col + $x];
                }
                ++$index;
            }
        }

        return $hourglass;
    }

    /**
     * Convert loaded file lines to 2D array.
     * 
     * @return void
     */
    public function build2DArray()
    {
        foreach ($this->fileDataLines as $line) {
            $this->data[] = array_map('intval', explode(' ', $line));
        }
    }

    /**
     * Returns extracted hourglasses count from array ($data)
     * 
     * @return int count
     */
    public function hourglassesCount()
    {
        $this->extractHourglasses();

        return (int) count($this->hourglasses);
    }

    /**
     * Returns the largest sum among all the hourglasses in the array ($data)
     * 
     * @return int largest sum
     */
    public function hourglassesMaxSum()
    {
        $this->extractHourglasses();

        return (int) max(array_map('array_sum', $this->hourglasses));
    }

}

$obj = new ConvertClass('6x6.txt');
$obj->build2DArray();
var_dump($obj->data); // replaced echo with var_dump because the output is array
echo $obj->hourglassesCount() . PHP_EOL;
echo $obj->hourglassesMaxSum() . PHP_EOL;
