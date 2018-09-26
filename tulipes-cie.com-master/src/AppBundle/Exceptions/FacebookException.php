<?php

namespace AppBundle\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class FacebookException extends HttpException
{
    const FACEBOOK_INVALID_KEYS = 951;
    const CONNECTION_REFUSED    = 952;
    const REQUEST_ERROR         = 953;

    /**
     * FacebookException constructor.
     */
    public function __construct($statu)
    {
    }


}