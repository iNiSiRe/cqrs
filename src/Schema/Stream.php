<?php

namespace inisire\RPC\Schema;

class Stream extends Data
{
    public function getContentType(): ?string
    {
        return 'application/octet-stream';
    }
}