<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;


/**
 * Log model
 *
 * @method static \Illuminate\Database\Eloquent\Builder|static latest($column = null)
 *
 * @property integer $type
 * @property string $message
 * @property array $context
 */
class Log extends Model
{
    use HasFactory;

    const ERROR_STATUS = 1;
    const REQUEST_STATUS = 2;
    const RESPONSE_STATUS = 3;

    protected $appends = ['type_label'];

    protected $fillable = [
        'type',
        'message',
        'context'
    ];

    protected $casts = [
        'context' => 'array',
    ];

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            self::ERROR_STATUS => 'error',
            self::REQUEST_STATUS => 'request',
            self::RESPONSE_STATUS => 'response',
            default => 'unknown',
        };
    }

    public static function getList(): LengthAwarePaginator
    {
        return self::latest()->paginate(10);
    }

}
