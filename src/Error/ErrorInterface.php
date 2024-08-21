<?php

namespace inisire\RPC\Error;

use inisire\DataObject\Error\ErrorMessage;

interface ErrorInterface
{
    public function getCode(): string;
    public function getMessage(): ErrorMessage;
}