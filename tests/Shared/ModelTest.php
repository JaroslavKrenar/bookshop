<?php

/**
 *  @author Jaroslav Krenar
 */

use App\Shared\Model;

/**
 * Validation in model tests
 */
class ModelTest extends PHPUnit_Framework_TestCase {

    public function tearDown()
    {
        Mockery::close();
    }

    public function testValidateSuccess()
    {
        $response = Mockery::mock(StdClass::class);
        $response->shouldReceive('passes')->once()->andReturn(true);

        $validation = Mockery::mock(Illuminate\Validation\Validator::class);
        $validation->shouldReceive('make')
                ->once()
                ->andReturn($response);

        $model = new Model([], $validation);
        $result = $model->validate();

        // if validation passed TRUE is expected
        $this->assertTrue($result);
    }

    public function testValidateFail()
    {
        // Validator response fail
        $response = Mockery::mock(StdClass::class);

        $response->shouldReceive('messages')->once()->andReturn(new Illuminate\Support\MessageBag(['column' => 'error']));
        $response->shouldReceive('passes')->once()->andReturn(false);
       
        $validation = Mockery::mock(Illuminate\Validation\Validator::class);
        $validation->shouldReceive('make')
                ->once()
                ->andReturn($response);

        $model = new Model([], $validation);
        
        // we except a validator failure
        try{
            $result = $model->validate();
        } catch (\Exception $ex) {
            if($ex instanceof \App\Exceptions\ValidationException){
                $this->assertEquals(['column' => ['error']], $ex->getErrorData());
                return;
            }
            else{
                $this->fail('Exception class "'.\App\Exceptions\ValidationException::class.'" was expected');
            }
        }
        
        $this->fail('Failure was expected');
    }
}
