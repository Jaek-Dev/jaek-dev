<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api', [
            'except' => ['login', 'register']
        ]);
    }

    public function login(Request $request) {
        try {
            $validated = $request->validate([
                'login' => 'required|string',
                'password' => 'required|string',
            ]);

            $authType = $this->getAuthType($validated);
            $token = $this->loginBy($authType, $validated);

            return \response()->json([$authType, $token]);

            $credentials = $request->only('login', 'password');
            $token = Auth::attempt($credentials);

            if(!$token) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Incorrect credentials.',
                ], 401);
            }

            $user = Auth::user();
            return response()->json([
                'status' => 'success',
                'message' => 'Authenticated.',
                'data' => [
                    'user' => $user,
                    'authorization' => [
                        'token' => $token,
                        'type' => 'Bearer',
                    ]
                ]
            ]);
        } catch(\Throwable | \Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    protected function loginBy(string $type) {
        switch(\strtolower($type)) {
            default: return null;
        }
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        
        // $token = Auth::login($user);
        return response()->json([
            'status' => 'success',
            'message' => 'Authenticated.',
            'data' => [
                'user' => $user,
                // 'authorization' => [
                //     'token' => $token,
                //     'type' => 'Bearer',
                // ]
            ]
        ]);
    }

    public function logout() {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Logout successful.',
        ]);
    }

    public function refresh() {
        return [
            'status' => 'success',
            'message' => 'Authentication refreshed.',
            'data' => [
                'user' => Auth::user(),
                'authorization' => [
                    'token' => Auth::refresh(),
                    'type' => 'Bearer',
                ]
            ]
        ];
    }
}
