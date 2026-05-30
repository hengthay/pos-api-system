<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierRequest;
use App\Models\Suppliers;
use Illuminate\Support\Facades\Log;

class SuppliersController extends Controller
{
    public function index() {
        try {
            $suppliers = Suppliers::orderBy('id', 'asc')->get();

            if($suppliers->isEmpty()) {
                return $this->handleErrorResponse(null, "Suppliers not found.", 404);
            }

            return $this->handleResponse($suppliers, "Suppliers is successfully retrieved.");
        } catch (\Throwable $e) {
            return $this->handleResponse(null, $e->getMessage(), 500);
        }   
    }

    public function show($id) {
        try {
            $supplier = Suppliers::find($id);

            if(!$supplier) {
                return $this->handleErrorResponse(null, "Suppliers not found.", 404);
            }

            return $this->handleResponse($supplier, "Suppliers is successfully retrieved.");
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        } 
    }

    public function create(SupplierRequest $request) {
        try {
            // Insert suppliers data
            $supplier = Suppliers::create([
                "supplier_name" => $request->supplier_name,
                "contact_name" => $request->contact_name,
                "phone" => $request->phone,
                "address" => $request->address,
                "email" => $request->email
            ]);

            Log::debug("Supplier", [
                "Create Supplier" => $supplier
            ]);
            
            return $this->handleResponse($supplier, "Suppliers is created successfully.", 201);
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function update(SupplierRequest $request, $id) {
        try {
            // Find suppliers record
            $supplier = Suppliers::find($id);

            if(!$supplier) {
                return $this->handleErrorResponse(null, "Supplier not found.", 404);
            }

            $supplier->update([
                "supplier_name" => $request->supplier_name,
                "contact_name" => $request->contact_name,
                "phone" => $request->phone,
                "address" => $request->address,
                "email" => $request->email
            ]);

            Log::debug("Supplier", [
                "Updated Supplier" => $supplier
            ]);
            
            return $this->handleResponse($supplier, "Suppliers is updated successfully.", 200);
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function delete($id) {
        try {
            // Find supplier record
            $supplier = Suppliers::find($id);

            if(!$supplier) {
                return $this->handleErrorResponse(null, "Supplier not found.", 404);
            }

            $supplier->delete();

            return $this->handleResponse(null, "Supplier is deleted successfully.", 204);
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }
}
