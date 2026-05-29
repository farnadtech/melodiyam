<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class HomepageSection extends Model
{
    use HasSlug;

    protected $fillable = [
        'title', 'title_fa', 'slug', 'type', 'config',
        'sort_order', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'config' => 'array',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public static function getDefaultConfig(string $type): array
    {
        $defaults = [
            'limit' => 6,
            'columns' => '6',
            'layout' => 'grid',
            'sort_by' => 'release_date',
            'show_see_all' => true,
            'see_all_label' => 'مشاهده همه',
            'featured_only' => true,
            'show_count' => false,
        ];

        return match ($type) {
            'hero' => [
                'hero_title' => '',
                'hero_subtitle' => '',
                'hero_btn1_label' => '',
                'hero_btn1_url' => '',
                'hero_btn2_label' => '',
                'hero_btn2_url' => '',
                'hero_color_from' => '#0ea5e9',
                'hero_color_to' => '#d946ef',
            ],
            'featured_artists' => array_merge($defaults, ['limit' => 8, 'columns' => '8']),
            'genres' => array_merge($defaults, ['limit' => 12, 'columns' => '6', 'show_see_all' => false]),
            'banner' => [
                'banner_image' => '',
                'banner_url' => '',
                'banner_height' => '200',
            ],
            'featured_track' => array_merge($defaults, ['limit' => 5]),
            'track_shelf' => $defaults,
            default => $defaults,
        };
    }

    public function getConfigAttribute($value)
    {
        $config = json_decode($value, true) ?: [];
        $defaults = static::getDefaultConfig($this->type ?? '');
        
        return array_merge($defaults, $config);
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
