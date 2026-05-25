<?php

namespace App\Enums;

enum UserType: string
{
    case Listener = 'listener';
    case Artist = 'artist';
    case Admin = 'admin';
    case Moderator = 'moderator';

    public function label(): string
    {
        return match ($this) {
            self::Listener => 'شنونده',
            self::Artist => 'هنرمند',
            self::Admin => 'مدیر',
            self::Moderator => 'ناظر',
        };
    }
}
