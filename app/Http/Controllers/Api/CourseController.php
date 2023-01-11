<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CoursePostRequest;
use App\Http\Requests\ExercisePostRequest;
use App\Http\Requests\StudentPostRequest;
use App\Http\Resources\CourseResource;
use App\Http\Resources\MinimalCourseResource;
use App\Http\Resources\StudentResource;
use App\Models\Certification;
use App\Models\Course;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->user()->isAbleTo('view-all'))
            return response('unauthorized', 403);
        $sort = $request->get('sort', 'name');
        $sortDirection = $request->get('sortDirection', 'ASC');
        $search = $request->get('search', '');
        $filter = $request->get('filter', 'open');
        $courses = Course::select('courses.*')
            ->join('certifications', 'certifications.id', '=', 'courses.certification_id')
            ->where('certifications.name', 'like', '%' . $search . '%')
            ->orderBy('certifications.name', $sortDirection)
            ->orderBy('start_date', $sortDirection)
            ->orderBy('number', $sortDirection);
        if ($filter == 'open')
            $courses = $courses->whereNull('end_date');
        if ($filter == 'closed')
            $courses = $courses->whereNotNull('end_date');
        return CourseResource::collection($courses->jsonPaginate());
    }
    public function getAvailables(Request $request)
    {
        if (!$request->user()->isAbleTo('view-all'))
            return response('unauthorized', 403);
        $excluded = $request->get('exclude', null);
        $courses = Course::whereNull('end_date')->whereNotIn('id', explode('|', $excluded))->get();
        return MinimalCourseResource::collection($courses);
    }
    public function get(Request $request, Course $course)
    {
        if ($request->user()->isAbleTo('view-all') || in_array($request->user()->id, $course->users()->pluck('id')->toArray())) {
            return new CourseResource($course);
        } else return response('unauthorized', 403);
    }

    public function duplicate(Request $request, Course $course)
    {
        if ($request->user()->isAbleTo('edit-all')) {
            $newCourse = new Course();
            $cYear = Carbon::parse($course->start_date)->format('Y');

            $latestCourse = Course::where('certification_id', $course->certification_id)->whereYear('start_date', $cYear)->orderBy('number', 'DESC')->first();
            $number = 1;
            if ($latestCourse)
                $number = $latestCourse->number + 1;
            $newCourse->certification_id = $course->certification_id;
            $newCourse->number = $number;
            $newCourse->start_date = $course->start_date;
            $newCourse->save();
            foreach ($course->users as $id => $user) {
                $progress = null;
                if (!$user->pivot->teaching) {
                    $progress = $course->getEmptyProgress();
                }
                $newCourse->users()->attach($user->id, ['in_charge' => $user->pivot->in_charge, 'teaching' => $user->pivot->teaching, 'price' => $newCourse->certification->price, 'progress' => $progress]);
            }
            return response()->json(['id' => $newCourse->id]);
        } else return response('unauthorized', 403);
    }
    public function getStudent(Request $request, Course $course, $student_id)
    {
        if ($request->user()->isAbleTo('view-all') || $request->user()->id == $student_id) {
            $course->student_id = $student_id;
            return new StudentResource($course);
        } else return response('unauthorized', 403);
    }
    public function getByUser(Request $request, $user_id)
    {

        if ($request->user()->isAbleTo('view-all') || $request->user()->id == $user_id) {
            $sort = $request->get('sort', 'name');
            $sortDirection = $request->get('sortDirection', 'ASC');
            $search = $request->get('search', '');

            $courses = Course::select('courses.*')
                ->whereHas('users', fn ($query) => $query->where('id', '=', $user_id))
                ->join('certifications', 'certifications.id', '=', 'courses.certification_id')
                ->where('certifications.name', 'like', '%' . $search . '%')
                ->orderBy('certifications.name', $sortDirection)
                ->orderBy('start_date', $sortDirection)
                ->orderBy('number', $sortDirection);
            return CourseResource::collection($courses->jsonPaginate());
        } else return response('unauthorized', 403);
    }
    public function store(CoursePostRequest $request)
    {
        if ($request->user()->isAbleTo('edit-all')) {
            $validated = $request->validated();
            $data = $request->safe()->except(['users']);
            $cYear = Carbon::parse($data['start_date'])->format('Y');

            $latestCourse = Course::where('certification_id', $data['certification_id'])->whereYear('start_date', $cYear)->orderBy('number', 'DESC')->first();
            $data['number'] = 1;
            if ($latestCourse)
                $data['number'] = $latestCourse->number + 1;
            $course = Course::create($data);
            //$course->save();
            $users = $request->safe()->only(['users']);
            $course->users()->detach();


            foreach ($users['users'] as $id => $user) {
                $progress = null;
                if (!$user['teaching']) {
                    $progress = $course->getEmptyProgress();
                }
                $course->users()->attach($user['name'], ['in_charge' => $user['in_charge'], 'teaching' => $user['teaching'], 'price' => $user['price'], 'progress' => $progress]);
            }
            return new CourseResource($course);
        } else return response('unauthorized', 403);
    }
    public function update(CoursePostRequest $request, Course $course)
    {
        if ($request->user()->isAbleTo('edit-all')) {
            $validated = $request->validated();
            $data = $request->safe()->except(['users']);
            $isSameCertification = $course->certification_id == $data['certification_id'];
            if (!$isSameCertification) {
                $cYear = Carbon::parse($data['start_date'])->format('Y');

                $latestCourse = Course::where('certification_id', $data['certification_id'])->whereYear('start_date', $cYear)->orderBy('number', 'DESC')->first();
                $data['number'] = 1;
                if ($latestCourse)
                    $data['number'] = $latestCourse->number + 1;
            }

            $course->fill($data);

            $course->save();
            $users = $request->safe()->only(['users']);
            $sync_data = [];
            foreach ($users['users'] as $id => $user) {
                $oldUser = $course->users()->where('id', $user['name'])->first();
                if (!$isSameCertification || !$oldUser) {

                    $progress = null;
                    if (!$user['teaching']) {
                        $progress = $course->getEmptyProgress();
                    }
                    $sync_data[$user['name']] =  ['in_charge' => $user['in_charge'], 'teaching' => $user['teaching'], 'price' => $user['price'], 'progress' => $progress];
                } else {
                    $sync_data[$user['name']] = ['in_charge' => $user['in_charge'], 'teaching' => $user['teaching'], 'price' => $user['price']];
                }
            }
            $course->users()->sync($sync_data);
            return new CourseResource($course);
        } else return response('unauthorized', 403);
    }

    public function updateStudent(StudentPostRequest $request, Course $course, $student_id)
    {
        if ($request->user()->isAbleTo('edit-all')) {
            $validated = $request->validated();
            $data = collect($request->safe())->toArray();
            $u = $course->users()->where('user_id', $student_id)->first();
            $old_progress = $u->pivot->progress;
            $data['progress'] = $old_progress;
            $course->users()->sync([
                $student_id => $data,
            ], false);
            $course->student_id = $student_id;
            return new StudentResource($course);
        } else return response('unauthorized', 403);
    }
    public function destroy(Request $request, Course $course)
    {
        if ($request->user()->isAbleTo('delete-all')) {

            $course->users()->detach();
            $course->delete();
            return response()->json(['status' => 'deleted']);
        } else return response('unauthorized', 403);
    }
    public function updateExercise(ExercisePostRequest $request, Course $course, $student_id)
    {
        if ($request->user()->isAbleTo('edit-all')) {
            $validated = $request->validated();

            $u = $course->users()->where('user_id', $student_id)->first();
            $data = collect($request->safe())->toArray();
            $is_activity = $data['is_activity'];
            unset($data['is_activity']);
            $apply_all = $data['apply_all'];
            unset($data['apply_all']);
            if (!$apply_all) {
                $old_progress = $u->pivot->progress;
                $this->recuriveForEach($old_progress, $data, $is_activity);
                $syncData['progress'] = $old_progress;
                $course->users()->sync([
                    $student_id => $syncData,
                ], false);
            } else {
                $students = $course->users()->where('teaching', false)->get();
                foreach ($students as $student) {

                    $old_progress = $student->pivot->progress;
                    $this->recuriveForEach($old_progress, $data, $is_activity);
                    $syncData['progress'] = $old_progress;
                    $course->users()->sync([
                        $student->id => $syncData,
                    ], false);
                }
            }
            $course->student_id = $student_id;

            return new StudentResource($course);
        } else return response('unauthorized', 403);
    }
    private function recuriveForEach(&$array, $data, $is_activity = false)
    {
        if (!$is_activity) {
            foreach ($array as $key => &$value) {
                if (is_array($value)) {
                    if (isset($value['values'])) {
                        $this->recuriveForEach(($value['values']), $data);
                    } else {
                        if ($data['id'] == $value['uuid']) {
                            unset($data['id']);
                            $instr = User::find($data['instructor']);
                            unset($data['instructor']);
                            $value['instructor']['name'] = null;
                            $value['instructor']['number'] = null;
                            $value['instructor']['id'] = null;
                            if ($instr) {
                                $value['instructor']['name'] = $instr->lastname . ' ' . $instr->firstname;
                                $value['instructor']['number'] = $instr->ssi_number;
                                $value['instructor']['id'] = $instr->id;
                            }
                            $value = array_merge($value, $data);
                            break;
                        }
                    }
                }
            }
        } else {
            $this->findActivity($array, $data);
        }
    }
    private function findActivity(&$array, $data)
    {
        foreach ($array as $key => &$value) {
            if ($value['uuid'] == $data['id']) {
                $this->activityRecursive($value['values'], $data);
                break;
            } else if (isset($value['values'])) {
                $this->findActivity($value['values'], $data);
            }
        }
    }
    private function activityRecursive(&$array, $data)
    {
        foreach ($array as $key => &$value) {
            if (isset($value['values'])) {
                $this->activityRecursive($value['values'], $data);
            } else {
                $instr = User::find($data['instructor']);

                $value['instructor']['name'] = null;
                $value['instructor']['number'] = null;
                $value['instructor']['id'] = null;
                if ($instr) {
                    $value['instructor']['name'] = $instr->lastname . ' ' . $instr->firstname;
                    $value['instructor']['number'] = $instr->ssi_number;
                    $value['instructor']['id'] = $instr->id;
                }
                $newData = $data;
                unset($newData['id']);
                unset($newData['instructor']);
                $value = array_merge($value, $newData);
            }
        }
    }
}
