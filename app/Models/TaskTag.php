<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\TaskTag
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $tag_id
 * @property int|null $task_id
 * @method static \Illuminate\Database\Eloquent\Builder|TaskTag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskTag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskTag query()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskTag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskTag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskTag whereTagId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskTag whereTaskId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskTag whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|TaskTag whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|TaskTag onlyTrashed()
 * @method static \Illuminate\Database\Query\Builder|TaskTag withTrashed()
 * @method static \Illuminate\Database\Query\Builder|TaskTag withoutTrashed()
 */
class TaskTag extends Model
{
    use HasFactory, SoftDeletes;
}
