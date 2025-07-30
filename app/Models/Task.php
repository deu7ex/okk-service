<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;


/**
 * Task model
 *
 * @method static \Illuminate\Database\Eloquent\Builder|static latest($column = null)
 *
 * @property integer $status
 * @property string $audio_url
 * @property array $parameters
 * @property array $metadata
 */
class Task extends Model
{
    use HasFactory;

    const ERROR_STATUS = 4;
    const COMPLETE_STATUS = 3;
    const PROCESSING_STATUS = 2;
    const NEW_STATUS = 1;

    protected $appends = ['status_label'];

    protected $fillable = [
        'audio_url',
        'status',
        'parameters',
        'metadata'
    ];

    protected $casts = [
        'metadata' => 'array',
        'parameters' => 'array'
    ];

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::NEW_STATUS => 'new',
            self::PROCESSING_STATUS => 'processing',
            self::COMPLETE_STATUS => 'completed',
            self::ERROR_STATUS => 'failed',
            default => 'unknown',
        };
    }

    public static function getList(): LengthAwarePaginator
    {
        return self::latest()->paginate(10);
    }

    public static function recordDB($data): Task
    {
        return self::create([
            'audio_url' => $data['audio_url'],
            'status' => self::NEW_STATUS,
            'parameters' => $data['parameters'] ?? [],
            'metadata' => $data['metadata'] ?? [],
        ]);
    }
}
