<?php

namespace App\Http\Controllers\AdminController;

use App\Models\SchoolYear;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schoolyear = SchoolYear::all();
        $response = [
            'message' => 'Fetch all data successfully!',
            'data' => $schoolyear
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
            'start_year' => 'required|string',
            'end_year' => 'required|string',
        ]);
        $schoolyear = SchoolYear::create([
            'start_year' => $data['start_year'],
            'end_year' => $data['end_year'],
        ]);
        $response = [
            'message' => 'School Year created successfully!',
            'data' => $schoolyear,
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
        $schoolyear = SchoolYear::find($id);
        $response = [
            'message' => 'Fetch specific school year successfully!',
            'data' => $schoolyear,
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
        $schoolyear = SchoolYear::find($id);
        $schoolyear->update($request->all());

        $response = [
            'message' => 'School Year updated successfully!',
            'data' => $schoolyear,
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
        $schoolyear = SchoolYear::destroy($id);

        if($schoolyear==0){
            $response = [
                'message' => 'School Year not found.'
            ];
        }else{
            $response = [
                'message' => 'School Year deleted successfully!'
            ];
        }
        

        return response($response,200);
    }
}
