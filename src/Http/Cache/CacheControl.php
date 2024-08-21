<?php

namespace inisire\RPC\Http\Cache;

class CacheControl
{
    public function __construct(
        private ?bool $public = null,
        private ?bool $private = null,
        private ?int $maxAge = null,
        private ?bool $immutable = null
    )
    {
    }

    public function toString(): string
    {
        $options = [
            'public' => $this->public,
            'private' => $this->private,
            'max-age' => $this->maxAge,
            's-maxage' => $this->maxAge,
            'immutable' => $this->immutable
        ];

        $parts = [];
        foreach ($options as $key => $value) {
            if ($value === null) {
                continue;
            } elseif ($value === true) {
                $parts[] = $key;
            } else {
                $parts[] = sprintf('%s=%s', $key, $value);
            }
        }

        return implode(', ', $parts);
    }
}