<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
 */
class TaskId extends Model
{
    use HasFactory;
}
