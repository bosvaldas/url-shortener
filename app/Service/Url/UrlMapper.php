<?php
declare(strict_types=1);

namespace App\Service\Url;

use App\Models\UrlMapping;
use App\Service\Url\LongUrlModifier\LongUrlModifier;
use App\Service\Url\LongUrlModifier\PathInfo;
use Illuminate\Support\Str;

class UrlMapper
{
    private array $longUrlModifiers;

    public function __construct(LongUrlModifier ...$longUrlModifiers)
    {
        $this->longUrlModifiers = $longUrlModifiers;
    }

    public function mapUrls(array $longUrls): array
    {
        return array_map([$this, 'mapUrl'], $longUrls);
    }

    private function mapUrl(string $longUrl): array
    {
        $modifiedLongUrl = $this->modifyLongUrl($longUrl);

        $existingMapping = UrlMapping::where('long_url', $modifiedLongUrl)->first();
        if ($existingMapping) {
            $hash = $existingMapping->hash;
        } else {
            $hash = $this->generateShortUrlHash();
            UrlMapping::create(['hash' => $hash, 'long_url' => $modifiedLongUrl]);
        }

        $shortUrl = $this->createShortUrl($hash);

        return ['longUrl' => $longUrl, 'shortUrl' => $shortUrl];
    }

    private function modifyLongUrl(string $longUrl): string
    {
        $pathInfo = PathInfo::fromUrl($longUrl);

        foreach ($this->longUrlModifiers as $modifier) {
            $pathInfo = $modifier->modify($pathInfo);
        }

        return (string)$pathInfo;
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
