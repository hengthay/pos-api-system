<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\Customers;

class CustomersController extends Controller
{
    public function index() {
        try {
            $customers = Customers::orderBy('id', 'asc')->get();
            
            if($customers->isEmpty()) {
                return $this->handleErrorResponse(null, "All Customer is not found.");
            }

            return $this->handleResponse($customers, "All Customer is successfully retrieved.");
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function show($id) {
        try {
            $customers = Customers::find($id);
            
            if(!$customers) {
                return $this->handleErrorResponse(null, "Customer not found.");
            }

            return $this->handleResponse($customers, "Customer is successfully retrieved.");
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function create(CustomerRequest $request) {
        try {
            $customers = Customers::create([
                "name" => $request->name,
                "phone" => $request->phone,
                "address" => $request->address,
                "email" => $request->email
            ]);

            return $this->handleResponse($customers, "Customer is created successfully.", 201);
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function update(CustomerRequest $request, $id) {
        try {
            $customer = Customers::find($id);

            if(!$customer) {
                return $this->handleErrorResponse(null, "Customer not found.", 404);
            }

            $customer->update([
                "name" => $request->name,
                "phone" => $request->phone,
                "address" => $request->address,
                "email" => $request->email
            ]);

            return $this->handleResponse($customer, "Customer is updated successfully.", 200);
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function delete($id) {
        try {
            $customer = Customers::find($id);

            if(!$customer) {
                return $this->handleErrorResponse(null, "Customer not found.", 404);
            }

            return $this->handleResponse(null, "Customer is deleted successfully.", 204);
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }
}
