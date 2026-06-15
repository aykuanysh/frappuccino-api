<?php

namespace App\Enums;

use App\Enums\Concerns\HasValues;

enum TransactionType: string
{
    use HasValues;

    case Restock = 'restock';
    case Usage = 'usage';
    case Adjustment = 'adjustment';
    case Waste = 'waste';
}
