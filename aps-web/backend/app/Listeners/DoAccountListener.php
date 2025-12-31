<?php

namespace App\Listeners;

use App\Http\Controllers\AccountingController;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\UnitConversion;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class DoAccountListener
{
    private $cash_account_id = 2;
    private $capital_account_id = 1;
    private $product_account_id = 3;
    private $inventory_account = 4;
    private $customer_account = 5;
    private $asset_account = 6;
    private $profi_and_loss = 7;


    public function adjustmentAccounting($warehouse_id, $currency_id, $product_id, $amount, $particular, $module, $add){
        $accounting = new AccountingController();
        $capital_account = $accounting->systemAccount($warehouse_id, $currency_id, $this->capital_account_id);
        $inventory_account = $accounting->systemAccount($warehouse_id, $currency_id, $this->inventory_account, $product_id);

        if($add){
            Transaction::query()->create([
                'account_number' => $inventory_account,
                'account_type' => 'dr',
                'amount' => $amount,
                'particular' => $particular,
                'module' => $module
            ]);
            $accounting->systemAccount($warehouse_id, $currency_id, 1);
            Transaction::query()->create([
                'account_number' => $capital_account,
                'account_type' => 'cr',
                'amount' => $amount,
                'particular' => $particular,
                'module' => $module
            ]);
        }else{
            Transaction::query()->create([
                'account_number' => $inventory_account,
                'account_type' => 'cr',
                'amount' => $amount,
                'particular' => $particular,
                'module' => $module
            ]);
            $accounting->systemAccount($warehouse_id, $currency_id, 1);
            Transaction::query()->create([
                'account_number' => $capital_account,
                'account_type' => 'dr',
                'amount' => $amount,
                'particular' => $particular,
                'module' => $module
            ]);
        }
    }
    public function sale($warehouse_id, $currency_id, $product_id, $amount, $particular, $module, $customer_id){
        $accounting = new AccountingController();
        $customer_account = $accounting->systemAccount($warehouse_id, $currency_id, $this->customer_account);
        $cache_account = $accounting->systemAccount($warehouse_id, $currency_id, $this->cash_account_id);
        $inventory_account = $accounting->systemAccount($warehouse_id, $currency_id, $this->inventory_account, $product_id);
        $p_a_l = $accounting->systemAccount($warehouse_id, $currency_id, $this->profi_and_loss);



    }
    public function capital_entry($warehouse_id, $currency_id, $amount, $particular, $module, $add=true){
        $accounting = new AccountingController();
        $capital_account = $accounting->systemAccount($warehouse_id, $currency_id, $this->capital_account_id);
        $cash_account = $accounting->systemAccount($warehouse_id, $currency_id, $this->cash_account_id);

        if($add){
            Transaction::query()->create([
                'account_number' => $capital_account,
                'account_type' => 'cr',
                'amount' => $amount,
                'particular' => $particular,
                'module' => $module
            ]);
            Transaction::query()->create([
                'account_number' => $cash_account,
                'account_type' => 'dr',
                'amount' => $amount,
                'particular' => $particular,
                'module' => $module
            ]);
        }else{
            Transaction::query()->create([
                'account_number' => $capital_account,
                'account_type' => 'dr',
                'amount' => $amount,
                'particular' => $particular,
                'module' => $module
            ]);
            Transaction::query()->create([
                'account_number' => $cash_account,
                'account_type' => 'cr',
                'amount' => $amount,
                'particular' => $particular,
                'module' => $module
            ]);
        }
    }


    public function asset_entry($warehouse_id, $currency_id, $amount, $particular, $module){
        $accounting = new AccountingController();
        $asset_account = $accounting->systemAccount($warehouse_id, $currency_id, $this->asset_account);
        $cache_account = $accounting->systemAccount($warehouse_id, $currency_id, $this->cash_account_id);

        Transaction::query()->create([
            'account_number' => $cache_account,
            'account_type' => 'cr',
            'amount' => $amount,
            'particular' => $particular,
            'module' => $module
        ]);
        Transaction::query()->create([
            'account_number' => $asset_account,
            'account_type' => 'dr',
            'amount' => $amount,
            'particular' => $particular,
            'module' => $module
        ]);
    }

    public function handle(object $event): void
    {
        Log::error("THis iss for testing");
        $service = $event->service;
        $warehouse_id = $event->warehouse_id;
        $currency_id = $event->currency_id;
        $product_id = $event->product_id;
        $amount = $event->amount;
        $particular = $event->particular;
        $module = $event->module;
        $customer_id = $event->customer_id;

        Log::error($amount);
        switch ($service) {
            case 'adjustment': case 'product_adjustment':
                $this->adjustmentAccounting($warehouse_id, $currency_id, $product_id, (double)$amount, $particular, $module, true);
                break;
            case 'adjustment_rm':
                $this->adjustmentAccounting($warehouse_id, $currency_id, $product_id, (double)$amount, $particular, $module, false);
                break;
            case 'sale':
                $this->sale($warehouse_id, $currency_id, $product_id, (double)$amount, $particular, $module, $customer_id);
                break;
            case 'first_capital':
                $this->first_capital($warehouse_id, $currency_id, $amount, $particular, $module);
                break;
            case 'asset_entry':
                $this->asset_entry($warehouse_id, $currency_id, $amount, $particular, $module);
                break;
            case 'capital_add':
                $this->capital_entry($warehouse_id, $currency_id, $amount, $particular, $module);
                break;
            case 'capital_remove':
                $this->capital_entry($warehouse_id, $currency_id, $amount, $particular, $module, false);
                break;
            case 'purchase':
                $this->purchase($warehouse_id, $currency_id, $product_id, (double)$amount, $particular, $module, $customer_id, $amount);
                break;
        }
    }

    private function purchase($warehouse_id, $currency_id, $product_id, $amount, $particular, $module)
    {
        $accounting = new AccountingController();
        $cash = $accounting->systemAccount($warehouse_id, $currency_id, $this->cash_account_id);
        $inventory_account = $accounting->systemAccount($warehouse_id, $currency_id, $this->inventory_account, $product_id);
        Transaction::query()->create([
            'account_number' => $cash,
            'account_type' => 'cr',
            'amount' => $amount,
            'particular' => $particular,
            'module' => $module
        ]);
        Transaction::query()->create([
            'account_number' => $inventory_account,
            'account_type' => 'dr',
            'amount' => $amount,
            'particular' => $particular,
            'module' => $module
        ]);
    }
}
