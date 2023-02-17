<?php

namespace inisire\RPC\Http\Cache;

class Expires
{
    public function __construct(
        private \DateTimeInterface $expires
    )
    {
    }

    public function toString(): string
    {
        return $this->expires->format(\DateTimeInterface::RFC7231);
    }
}