<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $section = Section::all();
        $response = [
            'message' => 'Fetch all data successfully!',
            'data' => $section
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
            'section' => 'required|unique:sections,section|string',
        ]);
        $section = Section::create([
            'section' => $data['section'],
        ]);
        $response = [
            'message' => 'Section created successfully!',
            'data' => $section,
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
        $section = Section::find($id);
        $response = [
            'message' => 'Fetch specific section successfully!',
            'data' => $section,
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
        $section = Section::find($id);
        $section->update($request->all());

        $response = [
            'message' => 'Section updated successfully!',
            'data' => $section,
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
        $section = Section::destroy($id);

        if($section==0){
            $response = [
                'message' => 'Section not found.'
            ];
        }else{
            $response = [
                'message' => 'Section deleted successfully!'
            ];
        }
        

        return response($response,200);
    }
}