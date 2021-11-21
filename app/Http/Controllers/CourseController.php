<?php

namespace App\Http\Controllers;

use App\Course;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::all();

        return $this->createSuccessResponce($courses, 200);
    }

    public function show($id)
    {
        $course = Course::find($id);

        if ($course) {
            return $this->createSuccessResponce($course, 200);
        } else {
            return $this->createErrorMessage('The Course with {$id} Does Not Exists', 404);
        }
    }
}
