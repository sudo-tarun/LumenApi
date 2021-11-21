<?php

namespace App\Http\Controllers;

use App\Student;
use App\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::all();

        return $this->createSuccessResponce($teachers, 200);
    }

    public function show($id)
    {
        $teacher = Teacher::find($id);

        if ($teacher) {
            return $this->createSuccessResponce($teacher, 200);
        } else {
            return $this->createErrorMessage("The teacher with {$id} Does Not Exists", 404);
        }
    }

    public function store(Request $request)
    {
        $this->validateRequest($request);

        $teacher = Teacher::create($request->all());

        return $this->createSuccessResponce("teacher with id {$teacher->id} has been created", 201);
    }

    public function update(Request $request, $id)
    {
        $teacher = Teacher::find($id);

        if ($teacher) {
            $this->validateRequest($request);

            $teacher->name = $request->get('name');
            $teacher->phone = $request->get('phone');
            $teacher->address = $request->get('address');
            $teacher->profession = $request->get('profession');

            $teacher->save();

            return $this->createSuccessResponce("teacher with id {$teacher->id} is updated sucessfully", 200);
        }

        return $this->createErrorMessage('teacher with specified id does not exists', 404);
    }

    public function destroy($id)
    {
        $teacher = Teacher::find($id);

        if ($teacher) {
            $courses = $teacher->courses;

            if (sizeof($courses) > 0) {
                return $this->createErrorMessage("You caanat remove teacher with active courses remove coourse first",409);
            }
            $teacher->delete();

            return $this->createSuccessResponce("teacher with id {$id} is removed sucessfully", 200);
        }

        return $this->createErrorMessage('the teacher with specified id does not exists', 404);
    }

    public function validateRequest($request)
    {
        $rules  =
            [
                'name' => 'required',
                'phone' => 'required|numeric',
                'address' => 'required',
                'profession' => 'required|in:engineering,math,physics'
            ];

        $this->validate($request, $rules);
    }
}
