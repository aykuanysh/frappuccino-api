<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Recipe line linking a menu item to an inventory ingredient, carrying the
 * quantity of that ingredient consumed per unit of the menu item.
 */
#[Fillable(['menu_item_id', 'inventory_id', 'quantity'])]
class MenuItemIngredient extends Pivot
{
    protected $table = 'menu_item_ingredients';

    /**
     * Composite primary key (menu_item_id, inventory_id), so there is no
     * auto-incrementing id column.
     */
    public $incrementing = false;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:2',
        ];
    }

    /**
     * @return BelongsTo<MenuItem, $this>
     */
    public function menuItem(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class);
    }

    /**
     * @return BelongsTo<Inventory, $this>
     */
    public function inventory(): BelongsTo
    {
        return $this->belongsTo(Inventory::class);
    }
}
