<?php

/**
 *  @author Jaroslav Krenar
 */

$handle = fopen ("maximum_element.txt","r");
$numberOfQueries=intval(fgets($handle)); // is 10 first line from given code
$arr = array();

while($numberOfQueries--){
    
    $queryParts = explode(' ', fgets($handle));
    
    switch((int) $queryParts[0]){ // first element is a query type
        case 1:
            $arr[] = (int) $queryParts[1]; // query value
            break;
        case 2:
            array_pop($arr);
            break;
        case 3:
            print max($arr).PHP_EOL;
            break;
        default:
            throw new Exception('Undefined query type "'.$queryType.'"');
    }
}

fclose($handle);