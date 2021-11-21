<?php

namespace App\Http\Controllers;

use App\Course;
use App\Teacher;
use Illuminate\Http\Request;

class TeacherCourseController extends Controller
{
    public function index($id)
    {
        $teacher = Teacher::find($id);

        if ($teacher) {
            $courses = $teacher->courses;
            return $this->createSuccessResponce($courses, 200);
        }
        return $this->createErrorMessage('teacher with specified id doesnot exists', 404);
    }

    public function store(Request $request, $teacher_id)
    {
        $this->validateRequest($request);

        $teacher = Teacher::find($teacher_id);

        if ($teacher) {
            $course = Course::create([
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'value' => $request->get('value'),
                'teacher_id' => $teacher->id
            ]);

            return $this->createSuccessResponce("Course with Course id {$course->id} is cretaed and associated with teacher_id {$teacher_id}", 201);
        }
        return $this->createErrorMessage("Teacher with {$teacher_id} doesnt exists", 404);
    }

    public function update(Request $request, $teacher_id, $course_id)
    {
        $teacher = Teacher::find($teacher_id); {
            if ($teacher) {
                $course = Course::find($course_id);

                $this->validateRequest($request);
                if ($course) {
                    $course->title = $request->get('title');
                    $course->description = $request->get('description');
                    $course->value = $request->get('value');
                    $course->teacher_id = $teacher->id;

                    $course->save();

                    return $this->createSuccessResponce("course with course id {$course->id} is updated sucessfully", 200);
                }
                return $this->createErrorMessage("Cours does nt exist with Course id {$course_id}", 404);
            }
            return $this->createErrorMessage("teacher does nt exist with teacher id {$teacher_id}", 404);
        }
    }

    public function destroy($teacher_id, $course_id)
    {
        $teacher = Teacher::find($teacher_id); {
            if ($teacher) {
                $course = Course::find($course_id);
                if ($course) {

                    if ($teacher->courses()->find($course_id)) {
                        $course->students()->detach();

                        $course->delete();

                        return $this->createSuccessResponce("course with course id {$course->id} is removed sucessfully", 200);
                    }
                    return $this->createErrorMessage("Course with Course id {$course_id} is not associated with teacher id {$teacher_id}", 404);
                }
                return $this->createErrorMessage("Course with Course id {$course_id} dooes not exists", 404);
            }
            return $this->createErrorMessage("teacher does nt exist with teacher id {$teacher_id}", 404);
        }
    }


    public function validateRequest($request)
    {
        $rules  =
            [
                'title' => 'required',
                'description' => 'required',
                'value' => 'required|numeric'
            ];

        $this->validate($request, $rules);
    }
}
