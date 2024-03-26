<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UrlMappingsRequest;
use App\Service\Url\UrlMapper;
use Illuminate\Http\JsonResponse;

class UrlMappingsController extends Controller
{
    public function __construct(
        private UrlMapper $mapper
    )
    {
    }

    public function submit(UrlMappingsRequest $request): JsonResponse
    {
        $urls = $request->validated('urls.*.url');

        $mappings = $this->mapper->mapUrls($urls);

        return new JsonResponse(['mappings' => $mappings]);
    }
}
