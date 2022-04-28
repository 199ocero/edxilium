<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subject = Subject::all();
        $response = [
            'message' => 'Fetch all data successfully!',
            'data' => $subject
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
            'subject' => 'required|unique:subjects,subject|string',
        ]);
        $subject = Subject::create([
            'subject' => $data['subject'],
        ]);
        $response = [
            'message' => 'Subject created successfully!',
            'data' => $subject,
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
        $subject = Subject::find($id);
        $response = [
            'message' => 'Fetch specific subject successfully!',
            'data' => $subject,
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
        $subject = Subject::find($id);
        $subject->update($request->all());

        $response = [
            'message' => 'Subject updated successfully!',
            'data' => $subject,
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
        $subject = Subject::destroy($id);

        if($subject==0){
            $response = [
                'message' => 'Subject not found.'
            ];
        }else{
            $response = [
                'message' => 'Subject deleted successfully!'
            ];
        }
        

        return response($response,200);
    }
}
