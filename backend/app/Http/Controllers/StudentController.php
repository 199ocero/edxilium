<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $student = Student::all();
        $response = [
            'message' => 'Fetch all data successfully!',
            'data' => $student
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
            'email' => 'required|unique:students,email|string',
        ]);
        $student = Student::create([
            'first_name' => $data['first_name'],
            'middle_name' => $data['middle_name'],
            'last_name' => $data['last_name'],
            'age' => $data['age'],
            'gender' => $data['gender'],
            'contact_number' => $data['contact_number'],
            'email' => $data['email'],
        ]);
        $response = [
            'message' => 'Student created successfully!',
            'data' => $student,
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
        
        $student = Student::find($id);
        $response = [
            'message' => 'Fetch specific student successfully!',
            'data' => $student,
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
        $student = Student::find($id);
        $student->update($request->all());

        $response = [
            'message' => 'Student updated successfully!',
            'data' => $student,
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
        $student = Student::destroy($id);

        if($student==0){
            $response = [
                'message' => 'Student not found.'
            ];
        }else{
            $response = [
                'message' => 'Student deleted successfully!'
            ];
        }
        

        return response($response,200);
    }
}
