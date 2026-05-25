<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ThemeSetting extends Model
{
    protected $fillable = ['key', 'value', 'group', 'type', 'label', 'label_fa'];

    public static function get(string $key, $default = null)
    {
        return Cache::rememberForever("theme_setting.{$key}", function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    public static function set(string $key, $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget("theme_setting.{$key}");
        Cache::forget('theme_settings_all');
    }

    public static function getAll(): array
    {
        return Cache::rememberForever('theme_settings_all', function () {
            return static::pluck('value', 'key')->toArray();
        });
    }

    public static function getByGroup(string $group): array
    {
        return static::where('group', $group)->pluck('value', 'key')->toArray();
    }

    public static function clearCache(): void
    {
        $keys = static::pluck('key');
        foreach ($keys as $key) {
            Cache::forget("theme_setting.{$key}");
        }
        Cache::forget('theme_settings_all');
    }
}
