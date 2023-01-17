<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Task
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $parent_id
 * @property mixed|null $data
 * @property string|null $section
 * @property string|null $name
 * @property string|null $note
 * @property int $position
 * @property int|null $category_id
 * @property int $completed
 * @property string|null $due_at
 * @property string|null $completed_at
 * @method static \Illuminate\Database\Eloquent\Builder|Task newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Task newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Task query()
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereDueAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereSection($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TaskId[] $taskIds
 * @property-read int|null $task_ids_count
 * @method static \Illuminate\Database\Query\Builder|Task onlyTrashed()
 * @method static \Illuminate\Database\Query\Builder|Task withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Task withoutTrashed()
 * @property string $original_workflowy_id
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereOriginalWorkflowyId($value)
 */
class Task extends Model
{
    use HasFactory, SoftDeletes;

    public function taskIds()
    {
        return $this->hasMany(TaskId::class);
    }
}
