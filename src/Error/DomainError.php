<?php

namespace inisire\RPC\Error;

use inisire\DataObject\Error\ErrorMessage;
use inisire\RPC\Http\HttpResultInterface;
use inisire\RPC\Result\ResultInterface;

class DomainError implements ErrorInterface, ResultInterface, HttpResultInterface
{
    private string $code;
    private ErrorMessage $message;

    public function __construct(string $code, string $message)
    {
        $this->code = $code;
        $this->message = new ErrorMessage($message);
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getMessage(): ErrorMessage
    {
        return $this->message;
    }

    public function getHttpCode(): int
    {
        return 400;
    }

    public function getHttpHeaders(): array
    {
        return [];
    }

    public function getOutput(): mixed
    {
        return null;
    }
}