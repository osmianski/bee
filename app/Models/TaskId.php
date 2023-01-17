<?php

namespace App\Models;

use App\Enums\Section;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\TaskId
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $workflowy_id
 * @method static \Illuminate\Database\Eloquent\Builder|TaskId newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskId newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskId query()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskId whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskId whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskId whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskId whereWorkflowyId($value)
 * @mixin \Eloquent
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|TaskId whereDeletedAt($value)
 * @property int|null $task_id
 * @method static \Illuminate\Database\Eloquent\Builder|TaskId whereTaskId($value)
 * @property-read \App\Models\Task|null $task
 * @method static \Illuminate\Database\Query\Builder|TaskId onlyTrashed()
 * @method static \Illuminate\Database\Query\Builder|TaskId withTrashed()
 * @method static \Illuminate\Database\Query\Builder|TaskId withoutTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskId whereSection($value)
 * @property Section|null $section
 */
class TaskId extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'section' => Section::class,
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
