<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerController extends Controller
{
    public function index()
    {
        return Customer::paginate(15);
    }

    public function store(StoreCustomerRequest $request)
    {
        return response()->json(
            Customer::create($request->validated()), 201
        );
    }

    public function show(Customer $customer)
    {
        return $customer;
    }

    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $customer->update($request->validated());
        return $customer;
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return response()->noContent();
    }
}
