<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\Assign;
use Illuminate\Http\Request;

class AssignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $user = $user->role;
        if($user=='admin'){
            $subject = Assign::with('instructor','section','subject','schoolYear')->get();
            $response = [
                'message' => 'Fetch all data successfully!',
                'data' => $subject
            ];
            return response($response,200);
        }else{
            $response = [
                'message' => 'User unauthorized.',
            ];
            return response($response,401);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $user = $user->role;
        if($user=='admin'){
            $data = $request->validate([
                'section_id' => 'required|string',
                'subject_id' => 'required|string',
                'school_year_id' => 'required|string',
            ]);
            $assign = Assign::create([
                'section_id' => $data['section_id'],
                'subject_id' => $data['subject_id'],
                'school_year_id' => $data['school_year_id'],
            ]);
            $response = [
                'message' => 'Assign created successfully!',
                'data' => $assign,
            ];

            return response($response,201);
        }else{
             $response = [
                'message' => 'User unauthorized.',
            ];
            return response($response,401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
