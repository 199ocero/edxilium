<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Instructor;
use Illuminate\Http\Request;

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
        $data = $request->validate([
            'first_name' => 'required|string',
            'middle_name' => 'required|string',
            'last_name' => 'required|string',
            'age' => 'required|string',
            'gender' => 'required|string',
            'contact_number' => 'required|string',
        ]);
        $instructor = Instructor::create([
            'first_name' => $data['first_name'],
            'middle_name' => $data['middle_name'],
            'last_name' => $data['last_name'],
            'age' => $data['age'],
            'gender' => $data['gender'],
            'contact_number' => $data['contact_number'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        $response = [
            'message' => 'Instructor created successfully!',
            'data' => $instructor,
        ];
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
        $instructor = Instructor::destroy($id);

        if($instructor==0){
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
