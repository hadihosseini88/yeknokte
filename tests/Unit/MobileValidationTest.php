<?php

namespace Tests\Unit;

use Hadihosseini88\User\Rules\ValidMobile;
use PHPUnit\Framework\TestCase;

class MobileValidationTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_mobile_can_not_be_less_than_10_character()
    {
        $result = (new ValidMobile())->passes('','935456852');
        $this->assertEquals(0,$result);
    }
    public function test_mobile_can_not_be_more_than_10_character()
    {
        $result = (new ValidMobile())->passes('','93545685255');
        $this->assertEquals(0,$result);
    }

    public function test_mobile_should_start_by_9()
    {
        $result = (new ValidMobile())->passes('','3354568525');
        $this->assertEquals(0,$result);
    }
}
