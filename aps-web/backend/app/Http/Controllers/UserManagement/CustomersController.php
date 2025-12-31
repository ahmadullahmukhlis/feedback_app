<?php

namespace App\Http\Controllers\UserManagement;

use App\Helpers\DatatableBuilder;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserManagement\CustomersRequest;
use App\Http\Resources\UserManagement\CustomersResource;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('for-api')){
            return CustomersResource::collection(
                Customer::query()->get()
            );
        }
        $this->allowed('customers-access');
        $query = Customer::query();
        if($request->has('is_active')){
            if($request->get('is_active')=='true'){
                $query = $query->where('status', true);
            }else{
                $query = $query->where('status', false);
            }
        }
        $datatable = new DatatableBuilder($query, ['first_name', 'last_name', 'email', 'phone_number', 'address']);
        return CustomersResource::collection(
            $datatable->build()
        );
    }

    public function store(CustomersRequest $request)
    {
        $this->allowed('customers-create');
        Customer::query()->create($request->validated());
        return response()->json([
            'result' => true,
            'message' => "Created successfully"
        ]);
    }

    public function show(Request $request, Customer $customer)
    {
        $this->allowed('customers-access');
        return new CustomersResource($customer);
    }

    public function update(CustomersRequest $request, Customer $customer)
    {
        $this->allowed('customers-update');
        $customer->update($request->validated());
        return response()->json([
            'result' => true,
            'message' => "Updated successfully"
        ]);
    }

    public function destroy(Request $request, Customer $customer)
    {
        $this->allowed('customers-delete');
        $customer->delete();
        return response()->json([
            'result' => true,
            'message' => "Deleted successfully"
        ]);
    }
}
