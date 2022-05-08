<?php

namespace App\Http\Controllers\InstructorController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Instructor;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = auth()->user();
        $user = $user->role;
        if($user=='instructor'){
            $instructor = Instructor::where('instructor_id',auth()->id())->first();
            $response = [
                'message' => 'Fetch specific instructor successfully!',
                'data' => $instructor,
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $user = $user->role;
        if($user=='instructor'){
             $data = $request->validate([
                'first_name' => 'required|string',
                'middle_name' => 'required|string',
                'last_name' => 'required|string',
                'age' => 'required|string',
                'gender' => 'required|string',
                'contact_number' => 'required|string',
            ]);
            $instructor = Instructor::where('instructor_id',auth()->id())->first();
            $instructor->first_name = $data['first_name'];
            $instructor->middle_name = $data['middle_name'];
            $instructor->last_name = $data['last_name'];
            $instructor->age = $data['age'];
            $instructor->gender = $data['gender'];
            $instructor->contact_number = $data['contact_number'];
            $instructor->update();
    
            $response = [
                'message' => 'Instructor updated successfully!',
                'data' => $instructor,
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
