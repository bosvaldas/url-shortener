<?php
declare(strict_types=1);

namespace App\Service\Url;

use App\Models\UrlMapping;
use Illuminate\Support\Str;

class UrlMapper
{
    public function mapUrls(array $longUrls): array
    {
        return array_map([$this, 'mapUrl'], $longUrls);
    }

    private function mapUrl(string $longUrl): array
    {
        $existingMapping = UrlMapping::where('long_url', $longUrl)->first();
        if ($existingMapping) {
            $hash = $existingMapping->hash;
        } else {
            $hash = $this->generateShortUrlHash();
            UrlMapping::create(['hash' => $hash, 'long_url' => $longUrl]);
        }

        $shortUrl = $this->createShortUrl($hash);

        return ['longUrl' => $longUrl, 'shortUrl' => $shortUrl];
    }

    private function generateShortUrlHash(): string
    {
        do {
            $hash = Str::random(6);
        } while (UrlMapping::where('hash', $hash)->exists());

        $prefix = trim(config('url-mapping.short-url-prefix'), '/');
        if ($prefix) {
            $hash = "$prefix/$hash";
        }

        return $hash;
    }

    private function createShortUrl(string $hash): string
    {
        return sprintf(
            '%s/%s',
            rtrim(config('app.url'), '/'),
            $hash
        );
    }
}
