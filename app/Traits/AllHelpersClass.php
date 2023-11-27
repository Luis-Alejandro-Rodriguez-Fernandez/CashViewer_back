<?php


namespace App\Traits;


use App\Helpers\authClass as Auth;
use App\Helpers\generalClass as General;

trait AllHelpersClass
{
    public function generalMethods(): General
    {
        return new General;
    }

    public function authMethods(): Auth
    {
        return new Auth;
    }
}
