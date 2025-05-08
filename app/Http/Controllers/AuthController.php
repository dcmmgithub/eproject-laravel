<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\PasswordReset; // For password reset event
use Illuminate\Support\Str; // For password reset event

class AuthController extends Controller
{
    /**
     * Register a new user.
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20|unique:users',
            'gender' => 'required|string|in:male,female,other', // Adjust as needed
            'dob' => 'required|date_format:Y-m-d',
            'password' => 'required|string|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'password' => Hash::make($request->password),
        ]);

        // Optionally, log the user in and create a token
        // $token = $user->createToken('auth_token')->plainTextToken;
        // return response()->json(['user' => $user, 'token' => $token], 201);

        return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
    }

    /**
     * Log in an existing user.
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid login details'], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        // For APIs, you'd typically generate a token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    /**
     * Log out the user (invalidate token).
     */
    public function logout(Request $request)
    {
        // For Sanctum token-based auth
        if ($request->user()) { // Check if user is authenticated
            $request->user()->currentAccessToken()->delete();
            return response()->json(['message' => 'Successfully logged out']);
        }

        // For session-based auth (less common for pure backend APIs but possible)
        // Auth::logout();
        // $request->session()->invalidate();
        // $request->session()->regenerateToken();
        // return response()->json(['message' => 'Successfully logged out']);

        return response()->json(['message' => 'No user authenticated or token not found'], 401);

    }

    /**
     * Send a password reset link.
     */
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // This sends a notification (e.g., email) with the reset link.
        // Ensure your mail driver is configured in .env
        $status = Password::sendResetLink($request->only('email'));

        return $status == Password::RESET_LINK_SENT
                    ? response()->json(['message' => 'Password reset link sent.'])
                    : response()->json(['message' => 'Unable to send password reset link. May have throttled.'], 500);
    }

    /**
     * Reset the user's password.
     */
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60), // Optionally reset remember token
                ])->save();

                event(new PasswordReset($user)); // Dispatch event
            }
        );

        return $status == Password::PASSWORD_RESET
                    ? response()->json(['message' => 'Password has been reset.'])
                    : response()->json(['message' => __($status)], 400); // Provide the status message directly
    }
}