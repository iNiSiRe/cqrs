<?php

namespace inisire\RPC\Schema;

use inisire\DataObject\Schema\Type\Type;

class EmptyData extends Data
{
    public function __construct()
    {
        parent::__construct(null, null);
    }
}