<?php

namespace inisire\RPC\Result;


use inisire\RPC\Http\HttpResultInterface;

class Result implements ResultInterface, HttpResultInterface, MutableOutputInterface
{
    public function __construct(
        private mixed $output,
    )
    {
    }

    public function getOutput(): mixed
    {
        return $this->output;
    }

    public function getHttpCode(): int
    {
        return 200;
    }

    public function getHttpHeaders(): array
    {
        return [];
    }

    public function setOutput(mixed $output)
    {
        $this->output = $output;
    }
}