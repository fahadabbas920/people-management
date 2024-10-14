<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Exception;

class ApiAuthenticatedSessionController extends Controller
{
    // API login method
    public function login(Request $request)
    {
        try {
            // Validate login credentials
            $validatedData = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            // Attempt authentication
            if (!Auth::attempt($validatedData)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }

            $user = $request->user();

            // Attempt to generate token
            try {
                $token = $user->createToken('API Token')->plainTextToken;
            } catch (Exception $e) {
                Log::error('Error generating token for user: ' . $user->id, ['error' => $e->getMessage()]);
                return response()->json(['message' => 'Error generating authentication token'], 500);
            }

            // Return success response
            return response()->json([
                'token' => $token,
                'user' => $user,
            ], 200);

        } catch (ValidationException $e) {
            // Handle validation errors (e.g., invalid email or missing password)
            return response()->json([
                'message' => 'Validation error',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            // Catch unexpected errors and log them
            Log::error('Login error: ' . $e->getMessage());
            return response()->json([
                'message' => 'An unexpected error occurred. Please try again later.'
            ], 500);
        }
    }

    // API logout method
    public function logout(Request $request)
    {
        try {
            // Revoke all tokens for the authenticated user
            $request->user()->tokens()->delete();

            return response()->json(['message' => 'Logged out successfully'], 200);
        } catch (Exception $e) {
            Log::error('Logout error: ' . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred during logout. Please try again later.'
            ], 500);
        }
    }
}
