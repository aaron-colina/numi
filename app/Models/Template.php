<?php

namespace App\Models;

use App\Database\Model;
use App\Models\Organization;
use App\Models\Theme;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property string|null $category
 * @property int|null $theme_id
 * @property int|null $organization_id
 * @property array|null $view
 * @property array|null $preview_images
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 */
class Template extends Model
{
    /** @use HasFactory<\Database\Factories\TemplateFactory> */
    use HasFactory,
        SoftDeletes;

    protected $table = 'templates';

    protected $fillable = [
        'name',
        'description',
        'category',
        'theme_id',
        'organization_id',
        'view',
        'preview_images',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'view' => 'json',
        'preview_images' => 'array',
    ];

    /**
     * Get the theme associated with the template.
     */
    public function theme(): BelongsTo
    {
        return $this->belongsTo(Theme::class);
    }

    /**
     * Get the organization associated with the template.
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * Scope a query to only include global templates (not associated with any organization).
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeGlobal(Builder $query): Builder
    {
        return $query->whereNull('organization_id');
    }
} 