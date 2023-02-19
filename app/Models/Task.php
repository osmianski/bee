<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Task
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $project_id
 * @property int|null $parent_id
 * @property string $workflowy_id
 * @property string $name
 * @property string $type
 * @property int $position
 * @property string|null $description
 * @property string|null $planned_at
 * @property string|null $completed_at
 * @property string $path
 * @property int $is_leaf
 * @method static \Illuminate\Database\Eloquent\Builder|Task newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Task newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Task query()
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereIsLeaf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task wherePlannedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereWorkflowyId($value)
 * @mixin \Eloquent
 */
class Task extends Model
{
    use HasFactory;
}
