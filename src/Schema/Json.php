<?php

namespace inisire\RPC\Schema;

use inisire\DataObject\Schema\Type\Type;

class Json extends Data
{
    public function __construct(Type $schema)
    {
        parent::__construct('application/json', $schema);
    }
}