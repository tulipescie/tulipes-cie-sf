<?php

namespace AppBundle\Exceptions;


class InstagramNotFoundAccessTokenException extends \Exception
{
    public function __construct($message)
    {
        $this->message = $message;
    }

}