<?php

use PHPUnit\Framework\TestCase;
use Sassnowski\Result\Result;

class ResultTest extends TestCase
{
    /** @test */
    public function chain_multiple_successes_together()
    {
        $add1 = function ($value) {
            return Result::success($value + 1);
        };
        $mult2 = function ($value) {
            return Result::success($value * 2);
        };

        $actual = Result::from(1)->bind($add1)->bind($mult2);

        $this->assertTrue($actual->isSuccess());
        $this->assertEquals(4, $actual->get());
    }

    /** @test */
    public function short_circuit_if_a_computation_fails()
    {
        $fails = function () {
            return Result::failure('I failed!');
        };
        $throws = function () {
            throw new Exception('I should not have been called!');
        };

        $actual = Result::from(1)->bind($fails)->bind($throws);

        $this->assertTrue($actual->isFailure());
        $this->assertEquals('I failed!', $actual->get());
    }

    /** @test */
    public function chain_together_functions_that_do_not_return_an_instance_of_result()
    {
        $add1 = function ($value) {
            return $value + 1;
        };
        $mult2 = function ($value) {
            return $value * 2;
        };

        $actual = Result::from(1)->map($add1)->map($mult2);

        $this->assertTrue($actual->isSuccess());
        $this->assertEquals(4, $actual->get());
    }

    /** @test */
    public function dont_call_function_for_a_failure()
    {
        $actual = Result::failure(1)->map(function () {
            throw new Exception('I should not have been called!');
        });

        $this->assertTrue($actual->isFailure());
        $this->assertEquals(1, $actual->get());
    }

    /** @test */
    public function mix_and_match_bind_and_map()
    {
        $checkNumeric = function ($value) {
            if (!is_numeric($value)) {
                return Result::failure("$value is not numeric.");
            }

            return Result::success($value);
        };

        $add1 = function ($value) {
            return $value + 1;
        };

        $actual = Result::from('1')->bind($checkNumeric)->map($add1);
        $this->assertTrue($actual->isSuccess());
        $this->assertEquals(2, $actual->get());

        $actual2 = Result::from('a')->bind($checkNumeric)->map($add1);
        $this->assertTrue($actual2->isFailure());
        $this->assertEquals('a is not numeric.', $actual2->get());
    }
}
