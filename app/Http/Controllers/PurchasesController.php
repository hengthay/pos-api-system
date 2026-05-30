<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use App\Models\InventoryTransactions;
use App\Models\Products;
use App\Models\Purchases;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchasesController extends Controller
{
    public function index() {
        try {
            
            $purchases = Purchases::with([
                "purchaseItems",
                "supplier:id,supplier_name,contact_name,phone,email"
            ])->orderBy('id', 'asc')->get();

            if($purchases->isEmpty()) {
                return $this->handleErrorResponse(null, "All Purchase not found.", 404);
            }

            return $this->handleResponse($purchases, "Purchases is successfully retrieved.");
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function show($id) {
        try {
            // Find purchase 
            $purchases = Purchases::with([
                "purchaseItems",
                "supplier:id,supplier_name,contact_name,phone,email"
            ])->find($id);

            if(!$purchases) {
                return $this->handleErrorResponse(null, "Purchase not found.", 404);
            }

            return $this->handleResponse($purchases, "Purchases is successfully retrieved.");
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function create(PurchaseRequest $request) {
        try {

            // Get current user
            $userId = Auth::user()->id;

            $purchase = DB::transaction(function () use ($request, $userId) {
                $count = Purchases::withTrashed()->lockForUpdate()->count() + 1;

                // Generate Invoice
                $invoiceCode = 'INV-' . now()->format('Ymd') . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);

                // Create purchase with no total
                $purchase = Purchases::create([
                    "supplier_id" => $request->supplier_id,
                    "invoice_no" => $invoiceCode,
                    "total_amount" => 0,
                    "purchase_date" => $request->purchase_date,
                    "status" => $request->status,
                    "created_by" => $userId,
                ]);

                // store calculate total
                $totalAmount = 0;

                foreach($request->items as $item) {
                    $itemTotal = $item['quantity'] * $item['cost_price'];
                    $totalAmount += $itemTotal;

                    $purchase->purchaseItems()->create([
                        "product_id" => $item["product_id"],
                        "quantity" => $item["quantity"],
                        "cost_price" => $item["cost_price"],
                        "total" => $itemTotal,
                    ]);
                }

                if($request->status === "received") {
                    foreach($request->items as $item) {
                        // Update stock quantity
                        Products::where('id', $item['product_id'])
                                ->increment('stock_quantity', $item['quantity']);

                        // Record inventory transaction
                        InventoryTransactions::create([
                            "product_id" => $item['product_id'],
                            "transaction_type" => "purchase",
                            "quantity" => $item['quantity'],
                            "purchase_id" => $purchase->id,
                            "sale_id" => null,
                            "created_by" => $userId,
                        ]);
                    }
                }

                // Update total amount
                $purchase->update([
                    "total_amount" => $totalAmount
                ]);

                return $purchase;
            });

            return $this->handleResponse($purchase, "Purchase is created successfully.", 201);
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function update(PurchaseRequest $request, $id) {
        try {
            // Get current user
            $userId = Auth::user()->id;
            $purchase = Purchases::find($id);

            if(!$purchase){
                return $this->handleErrorResponse(null, "Purchase not found.", 404);
            }

            $purchase = DB::transaction(function () use ($request, $userId, $purchase) {
                // Update few record columns
                $purchase->update([
                    "supplier_id" => $request->supplier_id,
                    "purchase_date" => $request->purchase_date,
                    "status" => $request->status,
                    "created_by" => $userId
                ]);

                // Delete old record
                $purchase->purchaseItems()->delete();
                $totalAmount = 0;

                foreach($request->items as $item) {
                    $itemTotal = $item['quantity'] * $item['cost_price'];
                    $totalAmount += $itemTotal;

                    $purchase->purchaseItems()->create([
                        "product_id" => $item['product_id'],
                        "quantity"   => $item['quantity'],
                        "cost_price" => $item['cost_price'],
                        "total"      => $itemTotal,
                    ]);
                };
            
                // Update stock on products if items received
                if($request->status === "received") {
                    foreach($request->items as $item) {
                        // Update stock
                        Products::where('id', $item['product_id'])
                                ->increment('stock_quantity', $item["quantity"]);

                        //  Insert Record data 
                        InventoryTransactions::create([
                            "product_id" => $item['product_id'],
                            "transaction_type" => "purchase",
                            "quantity" => $item['quantity'],
                            "sale_id" => null,
                            "purchase_id" => $purchase->id,
                            "created_by" => $userId
                        ]);
                    }
                };

                // Update stock if item is cancelled
                if($request->status === "cancelled") {
                    foreach($request->items as $item) {
                        // Update stock
                        Products::where('id', $item['product_id'])
                                ->decrement('stock_quantity', $item['quantity']);

                        // Insert transaction record
                        InventoryTransactions::create([
                            "product_id" => $item['product_id'],
                            "transaction_type" => "adjustment",
                            "quantity" => -$item['quantity'], 
                            "purchase_id" => $purchase->id,
                            "sale_id" => null,
                            "created_by" => $userId,
                        ]);        
                    }
                }

                $purchase->update([
                    "total_amount" => $totalAmount
                ]);

                return $purchase;
            });

            return $this->handleResponse($purchase, "Purchase is updated successfully.", 200);
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function delete($id) {
        try {
            // find purchase
            $purchase = Purchases::find($id);

            if(!$purchase) {
                return $this->handleErrorResponse(null, "Purchase not found.", 404);
            }

            $purchase->delete();

            return $this->handleResponse(null, "Purchase is deleted successfully.", 204);
         } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }
}
