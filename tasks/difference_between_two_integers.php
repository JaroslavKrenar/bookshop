<?php
/**
 *  @author Jaroslav Krenar
 */

class Difference {

    private $elements = array();
    public $maximumDifference;

    public function __construct(array $elements)
    {
        $this->elements = $elements;
    }
    
    public function ComputeDifference()
    {
        $results = [];
        for($i = 0; $i < $count = count($this->elements); $i++){
            for($x = $i +1; $x < $count; $x++){
                $results[] = abs($this->elements[$i] - $this->elements[$x]);
            }
        }
        $this->maximumDifference = max($results);
    }
}

//End of Difference class
$N = intval(fgets(STDIN));
$a = array_map('intval', explode(' ', fgets(STDIN)));
$d = new Difference($a);
$d->ComputeDifference();
print ($d->maximumDifference);
?>