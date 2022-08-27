<?php

namespace Hadihosseini88\User\Tests\Unit;

use Hadihosseini88\User\Services\VerifyCodeService;
//use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class VerifyCodeServiceTest extends TestCase
{
    public function test_generated_code_is_6_digit()
    {
        $code = VerifyCodeService::generate();
        $this->assertIsNumeric($code,'Generated Code is not numeric');
        $this->assertLessThanOrEqual(999999,$code,'Generated Code is Less than 999999');
        $this->assertGreaterThanOrEqual(100000,$code,'Generated Code is Greater than 100000');
    }

    public function test_verify_code_can_store()
    {
        $code = VerifyCodeService::generate();
        VerifyCodeService::store(1,$code);
        $this->assertEquals($code,cache()->get('verify_code_1'),'both code is not equal please check the id or code');

    }

}
