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
 * @property string $parent_path
 * @property int $has_children
 * @method static \Illuminate\Database\Eloquent\Builder|Task newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Task newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Task query()
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereHasChildren($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereParentPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task wherePlannedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereWorkflowyId($value)
 * @property bool $is_obsolete
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereIsObsolete($value)
 * @mixin \Eloquent
 */
class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'parent_id',
        'workflowy_id',
        'name',
        'type',
        'position',
        'description',
        'planned_at',
        'completed_at',
        'parent_path',
        'has_children',
        'is_obsolete',
    ];

    protected $casts = [
        'type' => Task\Type::class,
        'planned_at' => 'datetime',
        'completed_at' => 'datetime',
        'has_children' => 'boolean',
        'is_obsolete' => 'boolean',
    ];
}
