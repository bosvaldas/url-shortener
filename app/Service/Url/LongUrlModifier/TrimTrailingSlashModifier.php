<?php
declare(strict_types=1);

namespace App\Service\Url\LongUrlModifier;

class TrimTrailingSlashModifier implements LongUrlModifier
{
    public function modify(PathInfo $longUrl): PathInfo
    {
        if ($longUrl->path) {
            $longUrl->path = rtrim($longUrl->path, '/');
        }

        return $longUrl;
    }
}
