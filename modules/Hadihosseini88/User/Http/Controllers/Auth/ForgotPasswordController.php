<?php

namespace Hadihosseini88\User\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Hadihosseini88\User\Http\Requests\ResetPasswordVerifyCodeRequest;
use Hadihosseini88\User\Http\Requests\SendResetPasswordVerifyCodeRequest;
use Hadihosseini88\User\Http\Requests\VerifyCodeRequest;
use Hadihosseini88\User\Models\User;
use Hadihosseini88\User\Repositories\UserRepo;
use Hadihosseini88\User\Services\VerifyCodeService;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function showVerifyCodeRequestForm()
    {
        return view('User::Front.passwords.email');
    }

    public function sendVerifyCodeEmail(SendResetPasswordVerifyCodeRequest $request)
    {

        $user = resolve(UserRepo::class)->findByEmail($request->email);

        // todo if code exist
        if ($user && !VerifyCodeService::has($user->id)) {
            $user->sendResetPasswordRequestNotification();

        }

        return view('User::Front.passwords.enter-verify-code-form');
    }

    public function checkVerifyCode(ResetPasswordVerifyCodeRequest $request)
    {

        $user = resolve(UserRepo::class)->findByEmail($request->email);
        if ($user == null || !VerifyCodeService::check($user->id, $request->verify_code)) {
            return back()->withErrors(['verify_code' => 'کد وارد شده معتبر نمی باشد!']);
        }
        auth()->loginUsingId($user->id);
        return redirect()->route('password.showResetForm');
    }

}
