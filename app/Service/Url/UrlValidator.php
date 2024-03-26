<?php
declare(strict_types=1);

namespace App\Service\Url;

use Illuminate\Support\Facades\Http;

class UrlValidator
{
    public function validate(array $urls): array
    {
        $threatMatches = $this->findThreatMatches($urls);
        if (!$threatMatches) {
            return [];
        }

        $errors = [];
        foreach ($threatMatches as $threatUrlMatch) {
            $errorIndex = $this->getErrorIndex($threatUrlMatch, $urls);
            $errors[$errorIndex] = 'This URL is not safe.';
        }

        return $errors;
    }

    private function findThreatMatches(array $urls): ?array
    {
        $threatEntries = [];
        foreach ($urls as $url) {
            if (!$url['url']) {
                continue;
            }

            $threatEntries[] = $url;
        }

        $apiKey = config('url-mapping.google-api-key') ?: throw new \RuntimeException('API key missing');
        $apiUrl = sprintf('https://safebrowsing.googleapis.com/v4/threatMatches:find?key=%s', $apiKey);

        $payload = [
            'client' => [
                'clientId' => 'url-shortener',
                'clientVersion' => '1.5.2',
            ],
            'threatInfo' => [
                'threatTypes' => ['MALWARE', 'SOCIAL_ENGINEERING'],
                'platformTypes' => ['WINDOWS'],
                'threatEntryTypes' => ['URL'],
                'threatEntries' => $threatEntries,
            ],
        ];

        return Http::post($apiUrl, $payload)->json('matches');
    }

    public function getErrorIndex(array $match, array $urls): string
    {
        $threatUrl = $match['threat']['url'];
        $requestBodyUrlIndex = array_search($threatUrl, array_column($urls, 'url'));

        return sprintf('urls.%d.url', $requestBodyUrlIndex);
    }
}
