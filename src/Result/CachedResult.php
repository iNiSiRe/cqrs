<?php

namespace inisire\RPC\Result;

use inisire\RPC\Http\HttpResultInterface;

class CachedResult implements ResultInterface, HttpResultInterface, MutableOutputInterface
{
    const MODE_PUBLIC = 'public';
    const MODE_PRIVATE = 'private';
    const OPTION_MAX_AGE = 'max-age';
    const OPTION_S_MAXAGE = 's-maxage';
    const OPTION_IMMUTABLE = 'immutable';

    private array $parts = [];

    public function __construct(
        private mixed $output,
        string $mode = self::MODE_PUBLIC,
        array $options = []
    )
    {
        $this->parts = [$mode];

        foreach ($options as $key => $value) {
            if ($value === true) {
                $this->parts[] = $key;
            } else {
                $this->parts[] = sprintf('%s=%s', $key, $value);
            }
        }
    }

    public function getHttpCode(): int
    {
        return 200;
    }

    public function getHttpHeaders(): array
    {
        return [
            'Cache-Control' => implode(', ', $this->parts)
        ];
    }

    public function getOutput(): mixed
    {
        return $this->output;
    }

    public function setOutput(mixed $output)
    {
        $this->output = $output;
    }
}
