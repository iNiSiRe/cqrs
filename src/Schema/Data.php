<?php

namespace inisire\RPC\Schema;

use inisire\DataObject\Schema\Type\Type;

class Data
{
    public function __construct(
        private ?string $contentType = null,
        private ?Type $schema = null
    )
    {
    }

    public function getContentType(): ?string
    {
        return $this->contentType;
    }

    public function getSchema(): ?Type
    {
        return $this->schema;
    }

    public function hasSchema(): bool
    {
        return $this->getSchema() !== null;
    }
}