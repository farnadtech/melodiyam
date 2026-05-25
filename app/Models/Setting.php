<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'group', 'type'];

    public static function get(string $key, $default = null)
    {
        return Cache::rememberForever("setting.{$key}", function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    public static function set(string $key, $value): void
    {
        $setting = static::where('key', $key)->first();
        $group = $setting?->group ?? 'general';
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget("setting.{$key}");
        Cache::forget('settings_all');
        Cache::forget("settings_group.{$group}");
    }

    public static function getAll(): array
    {
        return \Illuminate\Support\Facades\Cache::rememberForever('settings_all', function () {
            return static::pluck('value', 'key')->toArray();
        });
    }

    public static function getByGroup(string $group): array
    {
        return Cache::rememberForever("settings_group.{$group}", function () use ($group) {
            return static::where('group', $group)->pluck('value', 'key')->toArray();
        });
    }
}
