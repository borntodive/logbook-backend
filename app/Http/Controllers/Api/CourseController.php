<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Http\Resources\StudentResource;
use App\Models\Certification;
use App\Models\Course;
use App\Models\User;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->user()->isAbleTo('view_all_courses'))
            return response('unauthorized',403);
        $sort = $request->get('sort', 'name');
        $sortDirection = $request->get('sortDirection', 'ASC');
        $search=$request->get('search', '');
        $courses = Course::select('courses.*')
            ->join('certifications', 'certifications.id', '=', 'courses.certification_id')
            ->where('certifications.name', 'like', '%'.$search.'%')
            ->orderBy('certifications.name',$sortDirection)
            ->orderBy('start_date',$sortDirection)
            ->orderBy('number',$sortDirection);
             return CourseResource::collection($courses->jsonPaginate());

    }

     public function get(Request $request, Course $course)
    {
        if ($request->user()->isAbleTo('view_all_courses') || in_array($request->user()->id,$course->users()->pluck('id')->toArray()))
        {
            return new CourseResource($course);
        } else return response('unauthorized',403);

    }

    public function getStudent(Request $request, Course $course, $student_id)
    {
        if ($request->user()->isAbleTo('view_all_courses') || $request->user()->id==$student_id)
       {
            $course->student_id = $student_id;
            return new StudentResource($course);
       }
       else return response('unauthorized',403);


    }
    public function getByUser(Request $request,$user_id)
    {

        if ($request->user()->isAbleTo('view_all_courses') || $request->user()->id==$user_id) {
            $sort = $request->get('sort', 'name');
            $sortDirection = $request->get('sortDirection', 'ASC');
            $search=$request->get('search', '');

            $courses = Course::select('courses.*')
            ->whereHas('users', fn  ($query) => $query->where('id', '=', $user_id))
            ->join('certifications', 'certifications.id', '=', 'courses.certification_id')
            ->where('certifications.name', 'like', '%'.$search.'%')
            ->orderBy('certifications.name',$sortDirection)
            ->orderBy('start_date',$sortDirection)
            ->orderBy('number',$sortDirection);
             return CourseResource::collection($courses->jsonPaginate());

       }
       else return response('unauthorized',403);
    }
}
