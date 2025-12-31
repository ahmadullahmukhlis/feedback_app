<?php

namespace App\Listeners;

use App\Events\NotifyEvent;
use App\Events\StockUpdatedEvent;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\UnitConversion;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ProductStockChangedListener
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
        $product_inventory = Inventory::query()
            ->where('product_id', $product['id'])
            ->where('warehouse_id', $warehouse_id)
            ->where('purchase_unit_id', $original_product->purchase_unit_id);
        $purchase_unit_conversion = UnitConversion::query()->find($product['unit']['id']);
        $qty = (double)$product['qty'];
        if($original_product->purchase_unit_id != $product['unit']['id'])
        {
            $qty = ($qty) / (double)$purchase_unit_conversion->amount;
        }
        if($product['type'] == "Addition"){
            if($product_inventory->exists()){
                $product_inventory->update([
                    'qty' => (double)$product_inventory->first()->qty + $qty
                ]);
            }else{
                $come_from = 'Adjustment';
                if($product['type'] == "Addition"){
                    $come_from = "Purchase";
                }elseif($product['type'] == "Subtraction"){
                    $come_from = "Sale";
                }
                Inventory::query()->create([
                    'product_id' => $product['id'],
                    'came_from' => $come_from,
                    'came_from_id' => 1,
                    'qty' => $qty,
                    'purchase_unit_id' => $original_product->purchase_unit_id,
                    'warehouse_id' => $warehouse_id
                ]);
            }
        }else{
            if($product_inventory->exists()){
                if((double)$product_inventory->first()->qty - $qty < 0){
                    $product_inventory->update([
                        'qty' => 0
                    ]);
                }else{
                    $product_inventory->update([
                       'qty' => (double)$product_inventory->first()->qty - $qty
                    ]);
                }
            }
        }
    }
}
