<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;


/**
 * Evaluation model
 *
 * @method static \Illuminate\Database\Eloquent\Builder|static latest($column = null)
 *
 * @property integer $task_id
 * @property double $score
 * @property string $summary
 * @property array $raw
 */
class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'score',
        'summary',
        'raw'
    ];

    protected $casts = [
        'score' => 'float',
        'raw' => 'array'
    ];

    public function getRouteKeyName(): string
    {
        return 'task_id';
    }

    public static function getList(): LengthAwarePaginator
    {
        return self::latest()->paginate(10);
    }
}
