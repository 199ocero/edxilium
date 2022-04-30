<?php

namespace App\Http\Controllers;

use App\Mail\Credentials;
use App\Models\User;
use App\Models\Instructor;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class InstructorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $instructor = User::latest()->get();
        $instructor = User::where('role','instructor')->latest()->get();
        $response = [
            'message' => 'Fetch all data successfully!',
            'data' => $instructor
        ];

        return response($response,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Create instructor account and save to users table
        // Only the instructors ID is save in instructors table
        $password = Str::random(30);

        $data = $request->validate([
            'role' => 'required|string',
            'email' => 'required|unique:users,email|string',
        ]);
        $instructor = User::create([
            'role' => $data['role'],
            'email' => $data['email'],
            'password' => bcrypt($password),
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

        $email = $data['email'];

        $instructor->sendEmailVerificationNotification();
        Mail::to($data['email'])->send(new Credentials($email,$password));


        return response($response,201);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $instructor = Instructor::where('instructor_id',$id)->first();
        $response = [
            'message' => 'Fetch specific instructor successfully!',
            'data' => $instructor,
        ];

        return response($response,200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $instructor = Instructor::find($id);
        $instructor->update($request->all());

        $response = [
            'message' => 'Instructor updated successfully!',
            'data' => $instructor,
        ];

        return response($response,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $instructor = Instructor::where('instructor_id',$id)->delete();
        $user = User::destroy($id);

        if($instructor==0 && $user==0){
            $response = [
                'message' => 'Instructor not found.'
            ];
        }else{
            $response = [
                'message' => 'Instructor deleted successfully!'
            ];
        }
        return response($response,200);

    }
    
}