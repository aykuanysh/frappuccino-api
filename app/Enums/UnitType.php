<?php

namespace App\Enums;

use App\Enums\Concerns\HasValues;

enum UnitType: string
{
    use HasValues;

    case Shots = 'shots';
    case Milliliters = 'ml';
    case Liters = 'l';
    case Grams = 'g';
    case Kilograms = 'kg';
    case Units = 'units';
    case Pieces = 'pieces';
}
