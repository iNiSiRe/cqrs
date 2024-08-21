<?php

namespace inisire\RPC\Error;

use inisire\DataObject\Error\ErrorMessage;
use inisire\RPC\Http\HttpResultInterface;
use inisire\RPC\Result\ResultInterface;

class DebugServerError implements ErrorInterface, ResultInterface, HttpResultInterface
{
    public function __construct(
        private \Throwable $error
    )
    {
    }

    public function getCode(): string
    {
        return '8ea34e11-64e1-431c-9e1d-bcbc8408d7ef';
    }

    public function getMessage(): ErrorMessage
    {
        return new ErrorMessage('Internal server error');
    }

    public function getHttpCode(): int
    {
        return 500;
    }

    public function getHttpHeaders(): array
    {
        return [];
    }

    public function getOutput(): mixed
    {
        return [
            'class' => $this->error::class,
            'message' => $this->error->getMessage(),
            'in' => $this->error->getFile() . ':' . $this->error->getLine(),
            'trace' => $this->error->getTrace()
        ];
    }
}