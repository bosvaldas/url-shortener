<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UrlMappingsRequest;
use App\Models\UrlMapping;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class UrlMappingsController extends Controller
{
    public function submit(UrlMappingsRequest $request): JsonResponse
    {
        $urls = $request->validated('urls');
        $mappings = [];

        foreach ($urls as $url) {
            $longUrl = $url['url'];

            $existingMapping = UrlMapping::where('long_url', $longUrl)->first();
            if ($existingMapping) {
                $hash = $existingMapping->hash;
            } else {
                $hash = $this->generateShortUrlHash();
                UrlMapping::create(['hash' => $hash, 'long_url' => $longUrl]);
            }

            $shortUrl = $this->createShortUrl($hash);

            $mappings[] = ['longUrl' => $longUrl, 'shortUrl' => $shortUrl];
        }


        return new JsonResponse(['mappings' => $mappings]);
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
