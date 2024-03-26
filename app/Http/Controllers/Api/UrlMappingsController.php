<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UrlMappingsRequest;
use Illuminate\Http\JsonResponse;

class UrlMappingsController extends Controller
{
    public function submit(UrlMappingsRequest $request): JsonResponse
    {
        $urls = $request->validated('urls');

        return new JsonResponse(['ok' => 1]);
    }
}
