<?php
/**
 *  @author Jaroslav Krenar
 */

namespace App\Exceptions;

/**
 * This trait add methods for storing error data
 */
trait ErrorDataTrait{
    
    /**
     * Error data
     * 
     * @var array 
     */
    protected $errorData = [];
    
    /**
     * Get error data
     * 
     * @return array 
     */
    public function getErrorData()
    {
        return $this->errorData;
    }
    
    /**
     * Sets error data
     * 
     * @param array $errorData
     * @return void
     */
    protected function setErrorData(array $errorData)
    {
        $this->errorData = $errorData;
    }
    
}