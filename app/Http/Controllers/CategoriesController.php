<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Categories;
use Illuminate\Support\Facades\Log;

class CategoriesController extends Controller
{
    public function index() {
        try {
            
            $categories = Categories::orderBy('id')->get();

            if($categories->isEmpty()) {
                return $this->handleResponse(null, "Category was not found.", 404);
            }

            return $this->handleResponse($categories, 'All Categories is successful retrieve.');
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function show($id) {
        try {
            
            $categories = Categories::find($id);

            if(!$categories) {
                return $this->handleResponse(null, "Category with ID {$id} not found.", 404);
            }

            return $this->handleResponse($categories, "Category retrieved successfully.");
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function create(CategoryRequest $request) {
        try {
            
            $category = Categories::create([
                "category_name" => $request->category_name,
                "description" => $request->description
            ]);

            Log::debug("category", [
                "category" => $category
            ]);

            if (!$category->wasRecentlyCreated) { 
                return $this->handleErrorResponse(null, "Unable to create category.", 500);
            }

            return $this->handleResponse($category, "Category created successfully.");
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function update(CategoryRequest $request, $id) {
        try {
            
            $category = Categories::find($id);

            if(!$category) {
                return $this->handleErrorResponse(null, "Category not found.", 404);
            }

            $category->update([
                "category_name" => $request->category_name,
                "description" => $request->description
            ]);

            return $this->handleResponse($category, "Category updated successfully.", 201);
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function delete($id) {
        try {
            
            $category = Categories::find($id);

            if(!$category) {
                return $this->handleErrorResponse(null, "Category not found.", 404);
            }

            $category->delete();

            return $this->handleResponse(null, "Category deleted successfully.", 203);
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }
}
