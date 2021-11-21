<?php

namespace App\Http\Controllers;

use App\Student;
use App\Teacher;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();

        return $this->createSuccessResponce($students, 200);
    }

    public function show($id)
    {
        $student = Student::find($id);

        if ($student) {
            return $this->createSuccessResponce($student, 200);
        } else {
            return $this->createErrorMessage('The Course with {$id} Does Not Exists', 404);
        }
    }

    public function store(Request $request)
    {

        $rules  =
            [
                'name' => 'required',
                'phone' => 'required|numeric',
                'address' => 'required',
                'career' => 'required|in:engineering,math,physics'
            ];

        $this->validateRequest($request);

        $student = Student::create($request->all());

        return $this->createSuccessResponce("Student with id {$student->id} has been created", 201);
    }

    public function update(Request $request, $id)
    {
        $student = Student::find($id);

        if ($student) {
            $this->validateRequest($request);


            $student->name = $request->get('name');
            $student->phone = $request->get('phone');
            $student->address = $request->get('address');
            $student->career = $request->get('career ');

            $student->save();

            return $this->createSuccessResponce("Student with id {$student->id} is updated sucessfully", 200);
        }

        return $this->createErrorMessage('student with specified id does not exists', 404);
    }

    public function destroy($id)
    {
        $student = Student::find($id);

        if ($student) {
            $student->courses()->detach();
            $student->delete();

            return $this->createSuccessResponce("student with id {$id} is removed sucessfully",200);
        }

        return $this->createErrorMessage('the student with specified id does not exists', 404);
    }

    public function validateRequest($request)
    {
        $rules  =
            [
                'name' => 'required',
                'phone' => 'required|numeric',
                'address' => 'required',
                'career' => 'required|in:engineering,math,physics'
            ];

        $this->validate($request, $rules);
    }
}
