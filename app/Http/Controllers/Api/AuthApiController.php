<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Database\Factories\UserFactory;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthApiController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        $users = User::all();
        return response()->json($users, 200);
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
{
    // Validate the incoming request
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8', // Ensure password is provided and long enough
    ]);

    // If validation fails, return a 422 response with errors
    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // Create a new user, automatically assigning the 'user' role
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password), // Hash the password
        'role' => 'user', // Set default role as 'user'
    ]);

    // Respond with success message and created user details
    return response()->json(['message' => 'User created successfully', 'user' => $user], 201);
}


    /**
     * Display the specified user.
     */
    public function show(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json($user, 200);
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, string $id)
{
    // Find the user by ID
    $user = User::find($id);

    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }

    // Ensure that the authenticated user is an admin
    if (Auth::user()->role !== 'admin') {
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    // Validate the incoming request data
    $validator = Validator::make($request->all(), [
        'name' => 'sometimes|string|max:255',
        'email' => 'sometimes|string|email|max:255|unique:users,email,' . $id,
        'password' => 'sometimes|string|min:8',
        'role' => 'sometimes|string|in:user,admin', // Only allow 'user' or 'admin' as roles
    ]);

    // If validation fails, return a 422 response with errors
    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // Update user data, including role if provided
    $user->update([
        'name' => $request->name ?? $user->name,
        'email' => $request->email ?? $user->email,
        'password' => $request->password ? bcrypt($request->password) : $user->password,
        'role' => $request->role ?? $user->role, // Update role if provided
    ]);

    return response()->json(['message' => 'User updated successfully', 'user' => $user], 200);
}


    /**
     * Remove the specified user from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json([], 200);
    }

    /**
     * Handle user login and generate a JWT token.
     */
    public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (!$token = JWTAuth::attempt($credentials)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    return $this->respondWithToken($token);
}


    /**
     * Handle user logout.
     */
    public function logout()
{
    try {
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json(['message' => 'Logged out successfully']);
    } catch (JWTException $e) {
        return response()->json(['error' => 'Failed to logout, token invalid'], 400);
    }
}


    /**
     * Get the authenticated user.
     */
    public function me()
    {
        return response()->json(Auth::user());
    }

    /**
     * Refresh a token.
     */
    public function refresh()
    {
        return $this->respondWithToken(Auth::refresh());
    }

    /**
     * Return the token structure.
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60,
        ]);
    }
}
