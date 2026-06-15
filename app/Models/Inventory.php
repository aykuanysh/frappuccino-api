<?php

namespace App\Models;

use App\Enums\UnitType;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'quantity', 'unit', 'price', 'reorder_level'])]
class Inventory extends Model
{
    /** @use HasFactory<\Database\Factories\InventoryFactory> */
    use HasFactory;

    /**
     * The table is singular ("inventory"), so it must be set explicitly
     * since Eloquent would otherwise look for "inventories".
     */
    protected $table = 'inventory';

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:2',
            'price' => 'decimal:2',
            'reorder_level' => 'decimal:2',
            'unit' => UnitType::class,
        ];
    }

    /**
     * @return HasMany<InventoryTransaction, $this>
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(InventoryTransaction::class);
    }

    /**
     * @return HasMany<MenuItemIngredient, $this>
     */
    public function ingredients(): HasMany
    {
        return $this->hasMany(MenuItemIngredient::class);
    }

    /**
     * Menu items that use this inventory item as an ingredient.
     *
     * @return BelongsToMany<MenuItem, $this>
     */
    public function menuItems(): BelongsToMany
    {
        return $this->belongsToMany(MenuItem::class, 'menu_item_ingredients')
            ->using(MenuItemIngredient::class)
            ->withPivot('quantity')
            ->withTimestamps();
    }
}
