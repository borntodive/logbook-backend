<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Http\Resources\StudentResource;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->get('sort', 'name');
        $sortDirection = $request->get('sortDirection', 'ASC');
        $search=$request->get('search', '');

        return CourseResource::collection(Course::join('certifications', 'courses.certification_id', '=', 'certifications.id')->where('certifications.name','LIKE','%'.$search.'%')->orderBy('certifications.'.$sort,$sortDirection)->orderBy('start_date',$sortDirection)->orderBy('number',$sortDirection)->jsonPaginate());

    }

     public function get(Request $request, Course $course)
    {
        return new CourseResource($course);
    }

    public function getStudent(Request $request, Course $course, $student_id)
    {
        $course->student_id = $student_id;
        return new StudentResource($course);
    }
}
