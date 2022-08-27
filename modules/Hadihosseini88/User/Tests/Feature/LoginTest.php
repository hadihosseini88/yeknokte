<?php

namespace Hadihosseini88\User\Tests\Feature;

use Hadihosseini88\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use function bcrypt;
use function route;

class LoginTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_login_by_email()
    {
        $user = User::create(
            [
                'name' => $this->faker->name,
                'email' => $this->faker->safeEmail,
                'password' => bcrypt('Aa@12345'),
            ]
        );
        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'Aa@12345',
        ]);
        $this->assertAuthenticated();
    }

    public function test_user_can_login_by_mobile()
    {
        $user = User::create(
            [
                'name' => $this->faker->name,
                'email' => $this->faker->safeEmail,
                'mobile' => '9104561234',
                'password' => bcrypt('Aa@12345'),
            ]
        );

        $this->post(route('login'), [
            'email' => $user->mobile,
            'password' => 'Aa@12345',
        ]);
        $this->assertAuthenticated();
    }
}
