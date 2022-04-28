<?php

namespace App\Http\Controllers;

use App\Models\Instructor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $data = $request->validate([
            'username' => 'required|unique:users,username|string',
            'role' => 'required|string',
            'email' => 'required|unique:users,email|string',
            'password' => 'required|confirmed|string',
        ]);
        if($data['role']=='instructor'){
            $instructor = User::create([
                'username' => $data['username'],
                'role' => $data['role'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]);
            Instructor::create([
                'instructor_id' => $instructor->id,
            ]);
            $token = $instructor->createToken('token')->plainTextToken;
            $response = [
                'message' => 'Instructor created successfully!',
                'data' => $instructor,
                'token' => $token
            ];
            return response($response,201);
        }else{
            $admin = User::create([
                'username' => $data['username'],
                'role' => $data['role'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]);
            $token = $admin->createToken('token')->plainTextToken;
            $response = [
                'message' => 'Admin created successfully!',
                'data' => $admin,
                'token' => $token
            ];
            return response($response,201);
        }
        
        
        
    }
    public function login(Request $request){
        $data = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        // Check email
        $user = User::where('email',$data['email'])->first();
        
        if(!$user || !Hash::check($data['password'],$user->password)){
            return response([
                'message' => 'Wrong credentials.'
            ],401);
        }
        $token = $user->createToken('token')->plainTextToken;
        if($user->role=='admin'){
            $response = [
                'message' => 'Admin login successfully!',
                'data' => $user,
                'token' => $token
            ];
            return response($response,200);
        }else{
            $response = [
                'message' => 'Instructor login successfully!',
                'data' => $user,
                'token' => $token
            ];
            return response($response,200);
        }
       
        
    }
    
    public function logout(Request $request){

        $request->user()->currentAccessToken()->delete();
        $response = [
            'message' => 'Logged out. Token destroyed, but do not worry as it will generate again when you login.'
        ];
        return response($response,200);
    }
}
