<?php
declare(strict_types=1);

namespace App\Service\Url\LongUrlModifier;

interface LongUrlModifier
{
    public function modify(PathInfo $longUrl): PathInfo;
}
