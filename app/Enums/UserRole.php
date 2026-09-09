<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case Viewer = 'viewer';

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Admin',
            self::Viewer => 'Viewer',
        };
    }
}
