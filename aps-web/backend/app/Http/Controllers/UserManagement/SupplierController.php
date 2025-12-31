<?php

namespace App\Http\Controllers\UserManagement;

use App\Helpers\DatatableBuilder;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserManagement\SupplierRequest;
use App\Http\Resources\UserManagement\SupplierResource;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request ){
        if($request->has('for-api')){
            return SupplierResource::collection(Supplier::all());
        }
        $this->allowed('suppliers-access');
        $query = Supplier::query()->with(['user', 'province']);
        if($request->has('is_active')){
            if($request->get('is_active') == 'true'){
                $query = $query->where('status', true);
            }
            if($request->get('is_active') == 'false'){
                $query = $query->where('status', false);
            }
        }
        $datatable = new DatatableBuilder($query, ['name','phone_number','email','address']);
        return SupplierResource::collection(
            $datatable->build()
        );
    }

    public function store(SupplierRequest $request ){
        $this->allowed('suppliers-create');
        $data = $request->validated();
        Supplier::query()->create($data);
        return response()->json([
            'result' => true,
            'message' => "Created successfully"
        ]);
    }

    public function update(Supplier $supplier, SupplierRequest $request ){
        $this->allowed('suppliers-update');
        $supplier->update($request->validated());
        return response()->json([
            'result' => true,
            'message' => "Updated successfully",
            'update_id' => $supplier->id
        ]);
    }

    public function destroy (Supplier $supplier ){
        $this->allowed('suppliers-delete');
        $supplier->delete();
        return response()->json([
            'result' => true,
            'message' => "Updated successfully"
        ]);
    }
}
