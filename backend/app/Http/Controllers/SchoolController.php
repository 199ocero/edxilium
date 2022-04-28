<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $school = School::all();
        $response = [
            'message' => 'Fetch all data successfully!',
            'data' => $school
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
            'school' => 'required|unique:schools,school|string',
        ]);
        $school = School::create([
            'school' => $data['school'],
        ]);
        $response = [
            'message' => 'School created successfully!',
            'data' => $school,
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
        $school = School::find($id);
        $response = [
            'message' => 'Fetch specific school successfully!',
            'data' => $school,
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
        $school = School::find($id);
        $school->update($request->all());

        $response = [
            'message' => 'School updated successfully!',
            'data' => $school,
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
        $school = School::destroy($id);

        if($school==0){
            $response = [
                'message' => 'School not found.'
            ];
        }else{
            $response = [
                'message' => 'School deleted successfully!'
            ];
        }
        

        return response($response,200);
    }
}
