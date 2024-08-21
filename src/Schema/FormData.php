<?php

namespace inisire\RPC\Schema;

use inisire\DataObject\Schema\Type\Type;

class FormData extends Data
{
    public bool $multipart;

    public function __construct(Type $schema, bool $multipart = false)
    {
        parent::__construct(null, $schema);
        $this->multipart = $multipart;
    }

    public function getContentType(): ?string
    {
        return $this->multipart
            ? 'multipart/form-data'
            : 'application/x-www-form-urlencoded';
    }
}