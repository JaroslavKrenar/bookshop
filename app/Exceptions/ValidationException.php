<?php
/**
 *  @author Jaroslav Krenar
 */

namespace App\Exceptions;

class ValidationException extends \Exception {

    use ErrorDataTrait;
    
    /**
     * Extract error messages from Laravel Validation and save to error data array
     * 
     * @param \Illuminate\Support\MessageBag $validationMessageBug
     * 
     */
    public function __construct(\Illuminate\Support\MessageBag $validationMessageBug)
    {
        $this->setErrorData($validationMessageBug->getMessages());
        
        parent::__construct('Invalid input data');
    }
}
