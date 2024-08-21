<?php

namespace inisire\RPC\Schema;

use inisire\DataObject\Schema\Type\Type;

#[\Attribute]
class Entrypoint
{
    public string $name;
    public ?Type $input = null;
    public ?Type $output = null;
    public ?string $description = null;

    public function __construct(string $name, ?Type $input = null, ?Type $output = null, ?string $description = null)
    {
        $this->name = $name;
        $this->input = $input;
        $this->output = $output;
        $this->description = $description;
    }
}