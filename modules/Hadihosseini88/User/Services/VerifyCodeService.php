<?php

namespace Hadihosseini88\User\Services;

class VerifyCodeService
{

    public static function generate()
    {
        return random_int(100000, 999999);
    }

    public static function store($id,$code)
    {
        cache()->set('verify_code_' . $id, $code,now()->addDay());
    }

    public static function get($id)
    {
        return cache()->get('verify_code_' . $id);
    }

    public static function delete(int $id)
    {
        return cache()->delete('verify_code_' . $id);
    }


}
