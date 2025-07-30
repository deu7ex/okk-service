<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;


/**
 * Segment model
 *
 * @method static \Illuminate\Database\Eloquent\Builder|static latest($column = null)
 *
 * @property integer $task_id
 * @property string $speaker
 * @property double $start
 * @property double $end
 * @property string $text
 */
class Segment extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'speaker',
        'start',
        'end',
        'text'
    ];

    protected $casts = [
        'start' => 'float',
        'end' => 'float',
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
