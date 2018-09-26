<?php

namespace AppBundle\Exception;


class FilterNotExistException extends \Exception
{

    /**
     * FilterNotExistException constructor.
     */
    public function __construct()
    {
        $message = "The filtres types not exist.";
        parent::__construct($message);
    }
}