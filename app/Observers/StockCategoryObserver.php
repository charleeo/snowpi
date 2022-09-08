<?php

namespace App\Observers;

use App\Models\StockCategory;
use Illuminate\Support\Str;

class StockCategoryObserver
{
    /**
     * Handle the StockCategory "created" event.
     *
     * @param  \App\Models\StockCategory  $stockCategory
     * @return void
     */
    public function created(StockCategory $stockCategory)
    {
        
        $stockCategory->category_slug  = Str::slug($stockCategory->category_name);
        $stockCategory->save();
    }

    /**
     * Handle the StockCategory "updated" event.
     *
     * @param  \App\Models\StockCategory  $stockCategory
     * @return void
     */
    public function updated(StockCategory $stockCategory)
    {
        //
    }

    /**
     * Handle the StockCategory "deleted" event.
     *
     * @param  \App\Models\StockCategory  $stockCategory
     * @return void
     */
    public function deleted(StockCategory $stockCategory)
    {
        //
    }

    /**
     * Handle the StockCategory "restored" event.
     *
     * @param  \App\Models\StockCategory  $stockCategory
     * @return void
     */
    public function restored(StockCategory $stockCategory)
    {
        //
    }

    /**
     * Handle the StockCategory "force deleted" event.
     *
     * @param  \App\Models\StockCategory  $stockCategory
     * @return void
     */
    public function forceDeleted(StockCategory $stockCategory)
    {
        //
    }
}
