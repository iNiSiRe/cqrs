<?php

namespace inisire\RPC\Security;

#[\Attribute(\Attribute::TARGET_METHOD)]
class Authorization
{
    public function __construct(
        private readonly string $role = 'IS_AUTHENTICATED_FULLY'
    )
    {
    }

    public function getRole(): string
    {
        return $this->role;
    }
}