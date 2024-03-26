<?php
declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $hash
 * @property string $long_url
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class UrlMapping extends Model
{
    use HasFactory;

    protected $fillable = [
        'hash',
        'long_url',
    ];
}
