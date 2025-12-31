<?php

namespace App\Listeners;

use App\Events\NotificationPushedEvent;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\ProductStockAlert;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ProductQtyListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $product = $event->product;
        $original_product = Product::query()->find($product['id']);
        $warehouse_id = $event->warehouse_id;
        if($product['type'] != "Addition"){
            $product_inventory = Inventory::query()
                ->where('product_id', $original_product->id)
                ->where('warehouse_id', $warehouse_id)
                ->where('purchase_unit_id', $original_product->purchase_unit->id)
                ->sum('qty');
            if($original_product->stock_alert >= $product_inventory){
                event(new NotificationPushedEvent('ProductStockAlert', $original_product->name.' ( '.$original_product->code.' ) stock alert', 'for-all', $original_product->id));
            }
            $original_product->update([
                'total_sales' => $original_product->total_sales + 1,
            ]);
            if(!ProductStockAlert::query()->where('product_id', $original_product->id)->where('warehouse_id', $warehouse_id)->exists()){
                ProductStockAlert::query()->create([
                    'product_id' => $original_product->id,
                    'warehouse_id' => $warehouse_id,
                    'purchase_unit_id' => $original_product->purchase_unit->id,
                    'alert_qty' => $original_product->stock_alert
                ]);
            }
        }else{
            $original_product->update([
                'total_purchase' => $original_product->total_purchase + 1,
            ]);
            ProductStockAlert::query()
                ->where('product_id', $original_product->id)
                ->where('warehouse_id', $warehouse_id)
                ->where('purchase_unit_id', $original_product->purchase_unit->id)
                ->delete();
        }
    }
}
