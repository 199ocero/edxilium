<?php

namespace App\Http\Controllers\AdminController;

use App\Models\Section;
use Illuminate\Http\Request;
use App\Imports\StudentImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\ValidationException;

class StudentSectionController extends Controller
{
    public function import(Request $request){
        $user = auth()->user();
        $user = $user->role;
        if($user=='admin'){
            $data = $request->validate([
                'section' => 'required|string',
                'file' => 'required|mimes:csv,txt'
            ]);
            $sectionUppercase = strtoupper($data['section']);
            $sectionName = Section::where('section',$sectionUppercase)->first();
            if($sectionName){
                throw ValidationException::withMessages([
                    'section' => 'The section has already been taken.'
                ]);
            }else{
                $section = Section::create([
                    'section' => $sectionUppercase,
                ]);
                $file = $request->file('file');
                Excel::import(new StudentImport($section->id), $file);
                $response = [
                        'message' => 'Student and section created successfully!',
                ];
                return response($response,200);
                
            }
            
            
        }else{
            $response = [
                'message' => 'User unauthorized.',
            ];
            return response($response,401);
        }
        
    }
}
