<?php

namespace App\Models;

use App\Enums\ItemSize;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'description', 'price', 'category_id', 'size', 'metadata'])]
class MenuItem extends Model
{
    /** @use HasFactory<\Database\Factories\MenuItemFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'size' => ItemSize::class,
            'metadata' => 'array',
        ];
    }

    /**
     * @return BelongsTo<Category, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return HasMany<OrderItem, $this>
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * @return HasMany<PriceHistory, $this>
     */
    public function priceHistory(): HasMany
    {
        return $this->hasMany(PriceHistory::class);
    }

    /**
     * @return HasMany<MenuItemIngredient, $this>
     */
    public function recipe(): HasMany
    {
        return $this->hasMany(MenuItemIngredient::class);
    }

    /**
     * @return BelongsToMany<Tag, $this>
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'menu_item_tag');
    }

    /**
     * @return BelongsToMany<Allergen, $this>
     */
    public function allergens(): BelongsToMany
    {
        return $this->belongsToMany(Allergen::class, 'menu_item_allergen');
    }

    /**
     * Inventory items consumed by this menu item, with the per-unit quantity
     * exposed as pivot data.
     *
     * @return BelongsToMany<Inventory, $this>
     */
    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Inventory::class, 'menu_item_ingredients')
            ->using(MenuItemIngredient::class)
            ->withPivot('quantity')
            ->withTimestamps();
    }
}
