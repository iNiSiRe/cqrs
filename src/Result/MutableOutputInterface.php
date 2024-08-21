<?php

namespace inisire\RPC\Result;

interface MutableOutputInterface
{
    public function setOutput(mixed $output);
}