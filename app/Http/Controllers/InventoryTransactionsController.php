<?php

namespace App\Http\Controllers;

use App\Models\InventoryTransactions;

class InventoryTransactionsController extends Controller
{
    public function index() {
        try {

            $inventories = InventoryTransactions::with([
                'product:id,product_name,product_code,cost_price,brand',
                'purchase:id,supplier_id,invoice_no,total_amount,status,purchase_date',
                'createdBy:id,name,role,phone'
            ])->orderBy('id', 'asc')->get();

            if($inventories->isEmpty()) {
                return  $this->handleErrorResponse(null, "All Inventory Transaction not found.", 404);
            }

            return $this->handleResponse($inventories, "Inventory Transaction is successfully retrieved.");
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function show($id) {
        try {
            $inventories = InventoryTransactions::with([
                'product:id,product_name,product_code,cost_price,brand',
                'purchase:id,supplier_id,invoice_no,total_amount,status,purchase_date',
                'createdBy:id,name,role,phone'
            ])->find($id);

            if(!$inventories) {
                return  $this->handleErrorResponse(null, "Inventory Transaction not found.", 404);
            }

            return $this->handleResponse($inventories, "Inventory Transaction is successfully retrieved.");
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }
}
