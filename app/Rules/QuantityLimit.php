<?php

namespace App\Rules;

use Closure;
use App\Models\currentStock;
use Illuminate\Contracts\Validation\ValidationRule;

class QuantityLimit implements ValidationRule
{
    protected $productId;
    protected $sizeId;
    protected $category;
    protected $now_qty;

    public function __construct($category, $productId, $sizeId, $now_qty)
    {
        $this->category = $category;
        $this->productId = $productId;
        $this->sizeId = $sizeId;
        $this->now_qty = $now_qty;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $category = $this->category; // Use $this->category to access the property
        $productId = $this->productId; // Use $this->productId to access the property
        $sizeId = $this->sizeId; // Use $this->sizeId to access the property
        $now_qty = $this->now_qty;
        $current = currentStock::where('category', $category)
            ->where('product_id', $productId)
            ->where('size_id', $sizeId)
            ->first();

        if ($current) {
            $maxQuantity = $current->quantity;
            if ($now_qty > $maxQuantity) {
                $fail('Only ' . $maxQuantity . ' sft available ');
            }
        } else {
            if (empty($now_qty) && $now_qty == null) {
                $fail('Tiles in sft is required');
            } else {
                $fail('product or size not exist');
            }
        }




        // Compare current quantity with max quantity limit

    }
}
