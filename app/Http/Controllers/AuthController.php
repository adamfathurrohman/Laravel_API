<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        //validation
        $validation = $request->validate([
            'email'=> ['required', 'email'],
            'password'=> ['required', 'string'],
        ]);
        if (! auth()->attempt($validation)) {
            return response()->json([   
                'message'=> 'Invalid credentials',],401);
            }
                return response()->json([
                    'message'=> 'Login successful',
                    'user' => auth()->user(),
                    'token' => auth()->user()->createToken('authToken')->plainTextToken,
                    'role' => auth()->user()->getRoleNames()->first(),
                ],200);
        }     

    /**
     * Store a newly created resource in storage.
     */
    public function register(Request $request)
    {
        // validation
        $validation = $request->validate([
            'name'=> ['required','string'],
            'email'=> ['required','email','unique:users'],
            'password'=> ['required','string','min:6','confirmed'],
        ]);
        
        //create user
        $user = User::create([
            'name'=> $validation['name'],
            'email'=> $validation['email'],
            'password'=> bcrypt($validation['password']),
        ]);

        $user->assignRole('customer');

        return response()->json([
            'message' => 'user created successfully',
            'user' => $user,
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function logout(Request $request)
    {
        auth()->user()->currentAccessToken()->delete();

        return response()->json([
            'message'=> 'Logout successful',
        ]);
    }

    

}


