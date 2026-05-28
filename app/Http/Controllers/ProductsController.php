<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Products;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
  public function index() {
    try {
      // Get all products and category_name
      $products = Products::with([
        'category:id,category_name,description'
      ])->orderBy('id', 'asc')
        ->get();

      if($products->isEmpty()) {
        return $this->handleErrorResponse(null, "All Product not found.", 404);
      }

      return $this->handleResponse($products, "Product is successfully retrieved.");
    } catch (\Throwable $e) {
      return $this->handleErrorResponse(null, $e->getMessage(), 500);
    }
  }

  public function show($id) {
    try {
      // Find product by id
      $product = Products::with([
        'category:id,category_name,description'
      ])->find($id);
      
      if(!$product) {
        return $this->handleErrorResponse(null, "Product not found.", 404);
      }

      return $this->handleResponse($product, "Product is successfully retrieved.");
    } catch (\Throwable $e) {
      return $this->handleErrorResponse(null, $e->getMessage(), 500);
    }
  }

  public function create(ProductRequest $request) {
    try {
      // Get image and store in storage folder
      $imagePath = null;

      if($request->hasFile('image_url')) {
        $imagePath = $request->file("image_url")->store('products', 'public');
      }

      // Keep increment inside transaction to prevent race condition.
      $product = DB::transaction(function () use ($request, $imagePath) {
          // Count
          $count = Products::withTrashed()->lockForUpdate()->count() + 1;
          // Generate unique code of product
          $productCode = 'PRO-' . now()->format('Ymd') . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
          
          return Products::create([
            "product_name" => $request->product_name,
            "product_code" => $productCode,
            "brand" => $request->brand,
            "cost_price" => $request->cost_price,
            "selling_price" => $request->selling_price,
            "stock_quantity" => $request->stock_quantity,
            "image_url" => $imagePath,
            "description" => $request->description,
            "category_id" => $request->category_id
          ]);
      });

      return $this->handleResponse($product, "Product is created successfully.", 201);
    } catch (\Throwable $e) {
      return $this->handleErrorResponse(null, $e->getMessage(), 500);
    }
  }

  public function update(ProductRequest $request, $id) {
    try {
      // Find product
      $product = Products::findOrFail($id);
      $imagePath = null;

      if(!$product) {
        return $this->handleErrorResponse(null, "Product not found.", 404);
      }

      // Check for new image uploading
      if($request->hasFile("image_url")) {
        // Remove previous image
        if($product->image_url && Storage::disk('public')->exists($product->image_url)) {
          Storage::disk("public")->delete($product->image_url);
        }
        // Store new image after remove previous
        $imagePath = $request->file("image_url")->store("products", 'public');
      }

      $product->update([
        "product_name" => $request->product_name,
        "brand" => $request->brand,
        "cost_price" => $request->cost_price,
        "selling_price" => $request->selling_price,
        "stock_quantity" => $request->stock_quantity,
        "image_url" => $imagePath,
        "description" => $request->description,
        "category_id" => $request->category_id
      ]);

      return $this->handleResponse($product, "Product is updated succesfully.", 200);
    } catch (\Throwable $e) {
      return $this->handleErrorResponse(null, $e->getMessage(), 500);
    }
  }

  public function delete($id) {
    try {
      // Find product
      $product = Products::findOrFail($id);

      if(!$product) {
        return $this->handleErrorResponse(null, "Product not found.", 404);
      }

      $product->delete();

      return $this->handleResponse(null, "Product is deleted successfully.", 204);
    } catch (\Throwable $e) {
      return $this->handleErrorResponse(null, $e->getMessage(), 500);
    }
  }
}
