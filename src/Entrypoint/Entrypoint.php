<?php

namespace inisire\RPC\Entrypoint;

use inisire\DataObject\Schema\Type\Type;
use inisire\RPC\Security\Authorization;

class Entrypoint
{
    public function __construct(
        private string         $name,
        private ?Type          $input,
        private ?Type          $output,
        private ?string        $description,
        private ?Authorization $authorization,
        private string         $root,
        private string         $method,
    )
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getInputSchema(): ?Type
    {
        return $this->input;
    }

    public function getOutputSchema(): ?Type
    {
        return $this->output;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getAuthorization(): ?Authorization
    {
        return $this->authorization;
    }

    public function getRoot(): string
    {
        return $this->root;
    }

    public function getMethod(): string
    {
        return $this->method;
    }
}