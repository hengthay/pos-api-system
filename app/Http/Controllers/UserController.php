<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index() {
        try {
            
            $users = User::where('status', 1)->orderBy('id', 'asc')->get();

            if($users->isEmpty()) {
                return $this->handleErrorResponse(null, "No user found was in database.");
            }

            return $this->handleResponse($users, "All Users are retrieve successful.");
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function show($id) {
        try {
            
            $users = User::find($id);

            if(!$users) {
                return $this->handleErrorResponse(null, "User with ID: " . $id . " is not found!", 404);
            }

            return $this->handleResponse($users, "User with ID: " . $id . " is successful retrieve.");
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function update(Request $request, $id) {
        try {
            
            // Query to find user by id
            $user = User::find($id);

            if(!$user) {
                return $this->handleErrorResponse(null, "User with ID: " . $id . ' is not found to update.', 404);
            }

            $user->update([
                "name" => $request->name,
                "password" => Hash::make($request->password),
                "email" => $request->email,
                "status" => $request->status
            ]);

            return $this->handleResponse($user, "User updated successfully.", 201);
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function delete($id) {
        try {
            
            $findUser = User::find($id);

            if(!$findUser) {
                return $this->handleErrorResponse(null, "User with ID: " . $id . ' is not found to delete.', 404);
            }

            $findUser->update([
                "status" => 0
            ]);

            return $this->handleResponse(null, "User deleted successfully.", 203);
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }
}
