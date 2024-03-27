<?php
declare(strict_types=1);

namespace App\Service\Url\LongUrlModifier;

class TrimFragmentModifier implements LongUrlModifier
{
    public function modify(PathInfo $longUrl): PathInfo
    {
        $longUrl->fragment = null;

        return $longUrl;
    }
}
