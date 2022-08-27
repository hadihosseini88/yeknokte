<?php

namespace Hadihosseini88\User\Services;

class VerifyCodeService
{

    public static function generate()
    {
        return random_int(100000, 999999);
    }

    public static function store($notifiable,$code)
    {
        cache()->set('verify_code_' . $notifiable->id, $code,now()->addDay());
    }
}
