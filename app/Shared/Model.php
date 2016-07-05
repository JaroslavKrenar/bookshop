<?php 
/**
 *  @author Jaroslav Krenar
 */

namespace App\Shared;

use Illuminate\Validation\Validator;

class Model extends \Illuminate\Database\Eloquent\Model {

    /**
     * Validation rules
     * 
     * @var Array
     */
    protected static $rules = array();

    /**
     * Validator instance
     * 
     * @var Illuminate\Validation\Validators
     */
    protected $validator;
    
    public function __construct(array $attributes = array(), Validator $validator = null)
    {
        parent::__construct($attributes);

        $this->validator = $validator ? $validator : \App::make('validator');
    }

    /**
     * Apply validation rules before saving
     * 
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function($model)
        {
            return $model->validate();
        });
    }

    /**
     *  Validate current attributes
     * 
     * @return boolean
     * @throws \App\Exceptions\ValidationException
     */
    public function validate()
    {
        $v = $this->validator->make($this->attributes, static::$rules);

        if ($v->passes())
        {
            return true;
        }

        throw new \App\Exceptions\ValidationException($v->messages());
    }
}
