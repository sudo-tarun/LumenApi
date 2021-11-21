<?php

namespace App\Http\Controllers;

use App\Course;
use App\Student;

class CourseStudentController extends Controller
{
    public function index($id)
    {
        $course = Course::find($id);

        if ($course) {
            $students = $course->students;
            return $this->createSuccessResponce($students, 200);
        }
        return $this->createErrorMessage('course with specified id doesnot exists', 404);
    }

    public function store($course_id, $student_id)
    {
        $course =  Course::find($course_id);
        if ($course) {
            $student = Student::find($student_id);

            if ($student) {

                if ($course->students()->find($student->id)) {

                    return $this->createErrorMessage("The Student wiith Student id {$student->id} already enroollled in course", 404);
                }

                $course->students()->attach($student->id);

                return $this->createSuccessResponce("The student with id {$student->id} enrolled to the course sucessfully", 200);
            }
        }
    }

    public function destroy($course_id,$student_id)
    {
        $course =  Course::find($course_id);
        if ($course) {
            $student = Student::find($student_id);

            if ($student) {

                if ($course->students()->find($student->id)) {
                    $course->students()->detach($student->id);

                    return $this->createSuccessResponce("The Student wiith Student id {$student->id} removed from the course", 200);
                }

                return $this->createErrorMessage("The student with id {$student->id} doesnot exixts in the course {$course->id}", 404);
            }
        }

        return $this->createErrorMessage("The course with id {$course_id} doesnot exixts", 404);
    }
}
