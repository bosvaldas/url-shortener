<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

abstract class Controller
{
    protected function json($data, $status = Response::HTTP_OK): JsonResponse
    {
        return new JsonResponse($data, $status);
    }
}
