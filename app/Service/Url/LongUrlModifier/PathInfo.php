<?php
declare(strict_types=1);

namespace App\Service\Url\LongUrlModifier;

class PathInfo
{
    private function __construct(
        public ?string $scheme = null,
        public ?string $host = null,
        public ?int    $port = null,
        public ?string $path = null,
        public ?string $query = null,
        public ?string $fragment = null
    )
    {
    }

    public static function fromUrl(string $url): static
    {
        $parsed = parse_url($url);

        return new static(
            scheme: $parsed['scheme'] ?? null,
            host: $parsed['host'] ?? null,
            port: $parsed['port'] ?? null,
            path: $parsed['path'] ?? null,
            query: $parsed['query'] ?? null,
            fragment: $parsed['fragment'] ?? null
        );
    }

    public function __toString(): string
    {
        $url = '';

        if ($this->scheme !== null) {
            $url .= $this->scheme . '://';
        }
        if ($this->host !== null) {
            $url .= $this->host;
        }
        if ($this->port !== null) {
            $url .= ':' . $this->port;
        }
        if ($this->path !== null) {
            $url .= $this->path;
        }
        if ($this->query !== null) {
            $url .= '?' . $this->query;
        }
        if ($this->fragment !== null) {
            $url .= '#' . $this->fragment;
        }

        return $url;
    }
}
