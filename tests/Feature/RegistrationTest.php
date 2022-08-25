<?php

namespace Tests\Feature;

use Hadihosseini88\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_see_register_from()
    {
        $response = $this->get(route('register'));
        $response->assertStatus(200);
    }

    public function test_user_can_register()
    {
        $response = $this->post(route('register'),[
            'name'=>'hadi',
            'email'=>'info@hadi1.com',
            'mobile'=>'9101239876',
            'password'=>'Aa@12345',
            'password_confirmation'=>'Aa@12345',
        ]);
        $this->assertCount(1,User::all());
    }

}
