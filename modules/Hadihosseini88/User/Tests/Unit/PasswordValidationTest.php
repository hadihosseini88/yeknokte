<?php

namespace Hadihosseini88\User\Tests\Unit;

use Hadihosseini88\User\Rules\ValidPassword;
use PHPUnit\Framework\TestCase;

class PasswordValidationTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_password_should_not_be_less_than_6_character()
    {
        $result = (new ValidPassword())->passes('', 'Aa@12');
        $this->assertEquals(0, $result);
    }

    public function test_password_should_include_sign_character()
    {
        $result = (new ValidPassword())->passes('', 'Aa12345');
        $this->assertEquals(0, $result);
    }

    public function test_password_should_include_digit_character()
    {
        $result = (new ValidPassword())->passes('', 'Aa@AAAAA');
        $this->assertEquals(0, $result);
    }
    public function test_password_should_include_capital_character()
    {
        $result = (new ValidPassword())->passes('', 'aa@12345');
        $this->assertEquals(0, $result);
    }
    public function test_password_should_include_small_character()
    {
        $result = (new ValidPassword())->passes('', 'AA@12345');
        $this->assertEquals(0, $result);
    }
}
