<?php

namespace App\Enums;

use App\Enums\Concerns\HasValues;

enum OrderChannel: string
{
    use HasValues;

    case Online = 'online';
    case Offline = 'offline';
}
