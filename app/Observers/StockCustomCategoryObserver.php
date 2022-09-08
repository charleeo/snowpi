<?php

namespace App\Observers;

use App\Models\StockCustomCategory;
use Illuminate\Support\Str;

class StockCustomCategoryObserver
{
    /**
     * Handle the StockCustomCategory "created" event.
     *
     * @param  \App\Models\StockCustomCategory  $stockCustomCategory
     * @return void
     */
    public function created(StockCustomCategory $stockCustomCategory)
    {
        $stockCustomCategory->custom_category_slug = Str::slug($stockCustomCategory->custom_category_name);
    }
    
    /**
     * Handle the StockCustomCategory "updated" event.
     *
     * @param  \App\Models\StockCustomCategory  $stockCustomCategory
     * @return void
     */
    public function updated(StockCustomCategory $stockCustomCategory)
    {
        $stockCustomCategory->custom_category_slug = Str::slug($stockCustomCategory->custom_category_name);
        //
    }
    
    /**
     * Handle the StockCustomCategory "deleted" event.
     *
     * @param  \App\Models\StockCustomCategory  $stockCustomCategory
     * @return void
     */
    public function deleted(StockCustomCategory $stockCustomCategory)
    {
        //
    }
    
    /**
     * Handle the StockCustomCategory "restored" event.
     *
     * @param  \App\Models\StockCustomCategory  $stockCustomCategory
     * @return void
     */
    public function restored(StockCustomCategory $stockCustomCategory)
    {
        $stockCustomCategory->custom_category_slug = Str::slug($stockCustomCategory->custom_category_name);
        $stockCustomCategory->save();
    }

    /**
     * Handle the StockCustomCategory "force deleted" event.
     *
     * @param  \App\Models\StockCustomCategory  $stockCustomCategory
     * @return void
     */
    public function forceDeleted(StockCustomCategory $stockCustomCategory)
    {
        //
    }
}
