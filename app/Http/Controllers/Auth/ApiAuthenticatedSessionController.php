<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

class ApiAuthenticatedSessionController extends Controller
{
    public function apiLogin(Request $request): JsonResponse
    {
        // Define validation rules and messages
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ], [
            'email.required' => 'Email is required',
            'email.email' => 'Email format is invalid',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 6 characters long',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Attempt to log in with the provided credentials
            if (Auth::attempt($request->only('email', 'password'))) {
                // Regenerate the session
                $request->session()->regenerate();

                // Create a Sanctum token for the user
                $user = Auth::user();
                $token = $user->createToken('YourAppName')->plainTextToken; // Create token using Sanctum

                return response()->json([
                    'message' => 'Login successful',
                    'user' => $user,
                    'token' => $token, // Return the token
                ], 200);
            } 

            // Incorrect credentials handling
            return response()->json([
                'message' => 'Invalid email or password. Please try again.'
            ], 401);

        } catch (Throwable $e) {
            // Catch any unexpected errors
            return response()->json([
                'message' => 'An error occurred during login. Please try again later.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Destroy an authenticated session for API.
     */
    public function apiLogout(Request $request): JsonResponse
    {
        try {
            if (Auth::check()) {
                // Revoke the user's tokens
                Auth::user()->tokens()->delete();

                // Log out the user
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return response()->json(['message' => 'Logout successful'], 200);
            }

            // If the user is not logged in
            return response()->json([
                'message' => 'No active session found. User is already logged out.'
            ], 400);

        } catch (Throwable $e) {
            // Catch any unexpected errors during logout
            return response()->json([
                'message' => 'An error occurred during logout. Please try again later.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
