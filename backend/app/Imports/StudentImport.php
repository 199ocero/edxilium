<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\StudentSection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class StudentImport implements ToModel, WithHeadingRow, WithValidation
{
    public function  __construct($section_id){
        $this->section_id= $section_id;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $number =$row['contact_number'];
        $result = sprintf("(%s) %s-%s",
              substr($number, 0, 3),
              substr($number, 3, 3),
              substr($number, 6));
        $student= Student::create([
            'section_id'=>$this->section_id,
            'student_id'=>$row['student_id'],
            'first_name'=>$row['first_name'],
            'middle_name'=>$row['middle_name'],
            'last_name'=>$row['last_name'],
            'age'=>$row['age'],
            'gender'=>$row['gender'],
            'contact_number'=>$result,
            'email'=>$row['email'],
        ]);
        return $student;

    }
    public function rules():array{
        return[
            'student_id'=>'required|unique:students,student_id',
            'email' => 'required|unique:students,email',
            'first_name' => 'required|string',
            'middle_name' => 'required|string',
            'last_name' => 'required|string',
            'age' => 'required',
            'gender' => 'required|string',
            'contact_number' => 'required',
        ];
    }

}