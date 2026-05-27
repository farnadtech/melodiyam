<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArtistApplicationField extends Model
{
    protected $fillable = [
        'key', 'label', 'type', 'options', 'required',
        'is_active', 'sort_order', 'placeholder', 'help_text',
    ];

    protected $casts = [
        'options'   => 'array',
        'required'  => 'boolean',
        'is_active' => 'boolean',
    ];

    public static array $types = [
        'text'     => 'متن کوتاه',
        'textarea' => 'متن بلند',
        'file'     => 'آپلود فایل',
        'select'   => 'انتخاب از لیست',
        'checkbox' => 'تیک (موافقت)',
        'url'      => 'لینک',
        'number'   => 'عدد',
    ];

    public static function activeFields()
    {
        return static::where('is_active', true)->orderBy('sort_order')->get();
    }
}
