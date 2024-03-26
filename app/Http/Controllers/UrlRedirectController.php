<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\UrlMapping;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class UrlRedirectController extends Controller
{
    public function redirect(string $hash): Response|RedirectResponse
    {
        $mapping = UrlMapping::where('hash', $hash)->first();
        if ($mapping) {
            return new RedirectResponse($mapping->long_url);
        } else {
            return new Response(null, Response::HTTP_NOT_FOUND);
        }
    }
}
