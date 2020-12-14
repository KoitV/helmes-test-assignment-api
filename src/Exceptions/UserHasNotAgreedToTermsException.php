<?php


namespace App\Exceptions;


use Exception;

class UserHasNotAgreedToTermsException extends Exception
{

    public function __construct()
    {
        parent::__construct('User has not agreed to terms.');
    }
}