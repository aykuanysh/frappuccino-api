<?php

namespace App\Enums;

use App\Enums\Concerns\HasValues;

enum ItemSize: string
{
    use HasValues;

    case Small = 'small';
    case Medium = 'medium';
    case Large = 'large';
}
