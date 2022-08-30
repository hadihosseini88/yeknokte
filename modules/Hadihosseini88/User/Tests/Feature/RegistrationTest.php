<?php

namespace Hadihosseini88\User\Tests\Feature;

use Hadihosseini88\User\Models\User;
use Hadihosseini88\User\Services\VerifyCodeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use function auth;
use function route;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * A basic feature user can see register from.
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
        $response = $this->registerNewUser();

        $response->assertRedirect(route('home'));

        $this->assertCount(1, User::all());
    }

    /**
     * A basic feature user have to verifu account.
     *
     * @return void
     */
    public function test_user_have_to_verify_account()
    {
        $this->registerNewUser();

        $response = $this->get(route('home'));

        $response->assertRedirect(route('verification.notice'));

    }

    public function test_user_can_verify_account()
    {
        $user = User::create(
            [
                'name' => $this->faker->name,
                'email' => $this->faker->safeEmail,
                'password' => bcrypt('Aa@12345'),
            ]
        );
        $code = VerifyCodeService::generate();
        VerifyCodeService::store($user->id, $code, now()->addDay());
        auth()->loginUsingId($user->id);
        $this->assertAuthenticated();

        $this->post(route('verification.verify'), [
            'verify_code' => $code,
        ]);
        $this->assertEquals(true, $user->fresh()->hasVerifiedEmail());

    }

    public function test_verified_user_can_see_home_page()
    {
        $this->registerNewUser();

        $this->assertAuthenticated();

        auth()->user()->markEmailAsVerified();

        $response = $this->get(route('home'));
        $response->assertOk();
    }

    private function registerNewUser()
    {
        return $this->post(route('register'), [
            'name' => 'hadi',
            'email' => 'inf@hadi1.com',
            'mobile' => '9101239876',
            'password' => 'Aa@12345',
            'password_confirmation' => 'Aa@12345',
        ]);
    }

}
