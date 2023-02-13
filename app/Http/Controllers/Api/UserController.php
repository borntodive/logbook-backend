<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserPostRequest;
use App\Http\Resources\AgendaResource;
use App\Http\Resources\MinimalRentResource;
use App\Http\Resources\MinimalUserResource;
use App\Http\Resources\RentResource;
use App\Mail\UserCreated;
use App\Models\Equipment;
use App\Models\Role;
use App\Models\RosterUser;
use App\Http\Resources\LoginResource;

use App\Models\Size;
use App\Models\User;
use App\Models\UserEmergencycontact;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Models\UserDuty;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->user()->isAbleTo('view-all'))
            return response('unauthorized', 403);
        $sort = $request->get('sort', 'lastname');
        $sortDirection = $request->get('sortDirection', 'ASC');
        $search = $request->get('search', '');

        return UserResource::collection(User::search($search, ['firstname', 'lastname'])->orderBy($sort, $sortDirection)->jsonPaginate());
    }

    public function getMe(Request $request)
    {
        $user = User::findOrFail($request->user()->id);
        $user->isLogin = false;
        return new LoginResource($user);
    }
    public function get(Request $request, $user_id)
    {
        if ($request->user()->isAbleTo('view-all') || $request->user()->id == $user_id) {
            return new UserResource(User::with('equipments')->findOrFail($user_id));
        } else return response('unauthorized', 403);
    }
    public function getDuties(Request $request)
    {
        if (!$request->user()->isAbleTo('view-all'))
            return response('unauthorized', 403);
        $duties = UserDuty::get();
        return response()->json($duties);
    }
    public function getRoles(Request $request)
    {
        if (!$request->user()->isAbleTo('manage-roles'))
            return response('unauthorized', 403);
        $roles = Role::get();
        return response()->json($roles);
    }
    public function updateRole(Request $request, User $user)
    {
        if (!$request->user()->isAbleTo('manage-roles'))
            return response('unauthorized', 403);
        $role = $request->input('role');
        $user->syncRoles([$role]);
        return response()->json(['message' => 'success']);
    }
    public function getAvailables(Request $request)
    {
        if (!$request->user()->isAbleTo('view-all'))
            return response('unauthorized', 403);
        $excluded = $request->get('exclude', null);
        $courses = User::whereNotIn('id', explode('|', $excluded))->orderBy('lastname')->orderBy('firstname')->get();
        return MinimalUserResource::collection($courses);
    }
    public function getUserRole(Request $request, User $user)
    {
        if (!$request->user()->isAbleTo('manage-roles'))
            return response('unauthorized', 403);
        $role = $user->roles()->first();
        return response()->json(['role_id' => $role->id]);
    }

    public function getStaff(Request $request)
    {
        if ($request->user()->isAbleTo('view-all')) {
            $excluded = $request->get('exclude', null);

            $query = User::select(['id', 'firstname', 'lastname', 'user_duty_id'])->whereNotIn('id', explode('|', $excluded))->orderBy('lastname', 'ASC')->where('user_duty_id', 3)->orWhere('user_duty_id', 2);
            return MinimalUserResource::collection($query->get());
        } else return response('unauthorized', 403);
    }
    public function getStudents(Request $request)
    {
        if ($request->user()->isAbleTo('view-all')) {
            $excluded = $request->get('exclude', null);

            $query = User::select(['id', 'firstname', 'lastname', 'user_duty_id'])->whereNotIn('id', explode('|', $excluded))->orderBy('lastname', 'ASC');
            return MinimalUserResource::collection($query->get());
        } else return response('unauthorized', 403);
    }
    public function update(UserPostRequest $request, User $user)
    {
        if ($request->user()->isAbleTo('edit-all') || $request->user()->id == $user->id) {
            $validated = $request->validated();
            $user->fill($request->safe()->except(['equipments', 'avatarName']));
            $equipments = $request->safe()->only(['equipments']);
            $avatarName = $request->avatarName;
            //dd(Storage::path('tmp'));
            //dd(Storage::exists('public/tmp/' . $avatarName));
            if ($avatarName && Storage::exists('public/tmp/' . $avatarName)) {
                Storage::move('public/tmp/' . $avatarName, 'public/images/avatars/' . $avatarName);
                $user->avatar = $avatarName;
            }
            $user->save();

            $user->equipments()->detach();
            foreach ($equipments['equipments'] as $id => $equipment) {
                $eq = Equipment::where('id', $equipment['equipment'])->first();
                if (is_numeric($equipment['size'])) {
                    $user->equipments()->attach($equipment['equipment'], ['number' => $equipment['size'], 'owned' => $equipment['owned']]);
                } else {
                    $size = Size::where('name', $equipment['size'])->first();
                    $user->equipments()->attach($equipment['equipment'], ['size_id' => $size->id, 'owned' => $equipment['owned']]);
                }
            }
            return new UserResource($user);
        } else return response('unauthorized', 403);
    }
    public function getRanking(Request $request)
    {
        if ($request->user()->isAbleTo('view-all')) {
            $year = $request->get('year', 'ALL');

            return response()->json($this->getRankingByYear($year));
        } else return response('unauthorized', 403);
    }
    private function getRankingByYear($year)
    {
        $users = User::whereHas('rosters', function ($query) use ($year) {
            $query->whereHas(
                'roster',
                function (Builder $query) use ($year) {
                    $query->where('type', 'DIVE')->where('date', '<=', now());
                    if ($year != 'ALL')
                        $query->whereYear('date', $year);
                }
            );
        })->withCount(['rosters' => function ($query) use ($year) {
            $query->whereHas(
                'roster',
                function (Builder $query) use ($year) {
                    $query->where('type', 'DIVE')->where('date', '<=', now());
                    if ($year != 'ALL')
                        $query->whereYear('date', $year);
                }
            );
        }])
            // ->where('user_duty_id', 1)

            ->orderBy('rosters_count', 'DESC')->get();
        $prevCount['total'] = null;
        $prevCount['male'] = null;
        $prevCount['female'] = null;
        $ranking = [];
        $ranking['total'] = [];
        $ranking['male'] = [];
        $ranking['female'] = [];
        $rank['total'] = null;
        $rank['male'] = null;
        $rank['female'] = null;
        foreach ($users as $user) {

            if (!$prevCount['total'] || $user->rosters_count < $prevCount['total']) {
                $rank['total']++;

                $prevCount['total'] = $user->rosters_count;
                $ranking['total'][$prevCount['total']]['rank'] = $rank['total'];
                $ranking['total'][$prevCount['total']]['count'] = $prevCount['total'];
            }
            $ranking['total'][$prevCount['total']]['users'][] = ["name" => $user->lastname . ' ' . $user->firstname, "id" => $user->id];
            if (!$prevCount[$user->gender] || $user->rosters_count < $prevCount[$user->gender]) {
                $rank[$user->gender]++;

                $prevCount[$user->gender] = $user->rosters_count;
                $ranking[$user->gender][$prevCount[$user->gender]]['rank'] = $rank[$user->gender];
                $ranking[$user->gender][$prevCount[$user->gender]]['count'] = $prevCount[$user->gender];
            }
            $ranking[$user->gender][$prevCount[$user->gender]]['users'][] = ["name" => $user->lastname . ' ' . $user->firstname, "id" => $user->id];
        }
        foreach ($ranking as $gender => $values) {
            $ranking[$gender] = array_values($values);
        }
        return $ranking;
    }
    public function uploadAvatar(Request $request)
    {
        if (!$request->user()->isAbleTo('edit-all'))
            return response('unauthorized', 403);


        $path = public_path('tmp/uploads');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        $file = $request->file('avatar');
        if ($file) {
            $name = uniqid() . '.' . trim($file->getClientOriginalExtension());
            $path = $request->file('avatar')->storeAs(
                'public/tmp',
                $name
            );

            return response()->json(['name' => $name, 'tempSrc' => Storage::url('tmp/' . $name)]);
        }
        return response()->json(['message' => 'error'], 405);
    }
    public function destroyAvatar(Request $request, User $user)
    {
        if (!$request->user()->isAbleTo('edit-all'))
            return response('unauthorized', 403);


        $user->avatar = null;
        $user->save();
        return response()->json(['message' => 'success', 'tempSrc' => $user->getAvatarUrl()]);
    }
    public function updateEmergency(Request $request, User $user)
    {
        if ($request->user()->isAbleTo('edit-all') || $request->user()->id == $user->id) {
            UserEmergencycontact::updateOrCreate(
                ['user_id' => $user->id],
                $request->all()
            );
            return new UserResource($user);
        } else return response('unauthorized', 403);
    }

    public function store(UserPostRequest $request)
    {
        if ($request->user()->isAbleTo('edit-all')) {
            $validated = $request->validated();
            $data = $request->safe()->except(['equipments']);
            $password = Str::random(9);
            $data['password'] = Hash::make($password);
            $user = User::create($data);
            $user->save();
            $userRole = Role::where(
                'name',
                'user'
            )->first();
            $equipments = $request->safe()->only(['equipments']);
            $user->attachRole($userRole);
            $user->equipments()->detach();
            foreach ($equipments['equipments'] as $id => $equipment) {
                $eq = Equipment::where('id', $equipment['equipment'])->first();
                if (is_numeric($equipment['size'])) {
                    $user->equipments()->attach($equipment['equipment'], ['number' => $equipment['size'], 'owned' => $equipment['owned']]);
                } else {
                    $size = Size::where('name', $equipment['size'])->first();
                    $user->equipments()->attach($equipment['equipment'], ['size_id' => $size->id, 'owned' => $equipment['owned']]);
                }
            }
            Mail::to($user->email)->send(new UserCreated($user, $password));
            return new UserResource($user);
        } else return response('unauthorized', 403);
    }
    public function destroy(Request $request, User $user)
    {
        if ($request->user()->isAbleTo('delete-all')) {

            $user->courses()->detach();
            $user->delete();
            return response()->json(['status' => 'deleted']);
        } else return response('unauthorized', 403);
    }

    public function getDashboard(Request $request)
    {
        $user = $request->user();
        $data = [];

        /*
        ###########
        ## STATS ##
        ###########
        */
        $data['stats']['courses'] = $user->courses()->count();
        $result = DB::select(DB::raw("SELECT
                                        count(*) AS count
                                    FROM
                                        `roster_user`
                                    WHERE
                                        `user_id` = :user_id
                                        AND EXISTS (
                                            SELECT
                                                *
                                            FROM
                                                `rosters`
                                                INNER JOIN `roster_dives` ON `rosters`.`id` = `roster_dives`.`roster_id`
                                            WHERE
                                                `roster_user`.`roster_dive_id` = `roster_dives`.`id`
                                                AND `type` = 'POOL'
                                            ORDER BY
                                                `roster_dives`.`date` ASC)"), array(
            'user_id' => $user->id,
        ));
        $pools = isset($result[0]->count) ? $result[0]->count : 0;
        $result = DB::select(DB::raw("SELECT
                                        count(*) AS count
                                    FROM
                                        `roster_user`
                                    WHERE
                                        `user_id` = :user_id
                                        AND EXISTS (
                                            SELECT
                                                *
                                            FROM
                                                `rosters`
                                                INNER JOIN `roster_dives` ON `rosters`.`id` = `roster_dives`.`roster_id`
                                            WHERE
                                                `roster_user`.`roster_dive_id` = `roster_dives`.`id`
                                                AND `type` = 'DIVE'
                                            ORDER BY
                                                `roster_dives`.`date` ASC)"), array(
            'user_id' => $user->id,
        ));
        $dives = isset($result[0]->count) ? $result[0]->count : 0;
        $data['stats']['dives'] = $dives;
        $data['stats']['pools'] = $pools;
        /*
        ###########
        ## RANK ##
        ###########
        */

        $overallRanking = $this->getRankingByYear('ALL');
        $yearRanking = $this->getRankingByYear(now()->format('Y'));

        $rank['total']['overall'] = null;
        $rank['total']['currentYear'] = null;
        $rank[$user->gender]['overall'] = null;
        $rank[$user->gender]['currentYear'] = null;

        foreach ($overallRanking as $gender => $positions) {
            foreach ($positions as $r) {
                if (isset($r['users'])) {
                    foreach ($r['users'] as $u) {
                        if ($u['id'] == $user->id) {
                            $rank[$gender]['overall'] = [
                                'rank'  => $r['rank'],
                                'count' => $r['count']
                            ];
                        }
                    }
                }
            }
        }
        foreach ($yearRanking as $gender => $positions) {
            foreach ($positions as $r) {
                if (isset($r['users'])) {
                    foreach ($r['users'] as $u) {
                        if ($u['id'] == $user->id) {
                            $rank[$gender]['currentYear'] = [
                                'rank'  => $r['rank'],
                                'count' => $r['count']
                            ];
                        }
                    }
                }
            }
        }
        $rank['gender'] = $user->gender;
        $data['rank'] = $rank;

        /*
        ############
        ## AGENDA ##
        ############
        */

        $agendaRes
            = new AgendaResource($user->rosters()->where('date', ">=", now())->jsonPaginate(2));
        $agenda = isset($agendaRes->appointments) ? $agendaRes->appointments : [];
        $data['agenda'] = $agendaRes;

        /*
        #############
        ## BALANCE ##
        #############
        */
        $balance = 0;
        $unpayedCourses = $user->unpayedCourses;
        foreach ($unpayedCourses as $course) {
            $cBalance = $course->pivot->price - $course->pivot->payment_1 - $course->pivot->payment_2 - $course->pivot->payment_3;
            $balance += $cBalance;
        }
        $unpayedRosters = $user->unpayedRosters;
        foreach ($unpayedRosters as $roster) {
            $rBalance = $roster->pivot->price;
            $balance += $rBalance;
        }
        $unpayedRents = $user->unpayedRents;
        foreach ($unpayedRents as $rent) {
            $rBalance = $rent->price * $rent->used_days - $rent->payment_1 - $rent->payment_2;
            $balance += $rBalance;
        }
        $data['balance'] = $balance;

        /*
        #############
        ## COURSE ##
        #############
        */

        $course = $user->openedCourses()->orderBy('start_date', 'DESC')->first();
        $data['course']['name'] = "";
        $data['course']['progress'] = "";
        if ($course) {
            $data['course']['name'] = $course->certification->name . ' ' . $course->number . '/' . $course->start_date->format('Y');
            $data['course']['id'] = $course->id;
            $total = 0;
            $completed = 0;
            if (!$course->pivot->teaching)
                $this->caluculateProgress($course->pivot->progress, $completed, $total);
            $data['course']['percent'] = $total ? $completed / $total : 0;
        }
        /*
        ###########
        ## RENTS ##
        ###########
        */
        $data['rents'] = [];
        $rents = $user->openRents()->orderBy('start_date')->limit(2)->get();
        if ($rents) {
            foreach ($rents as $rent) {
                $data['rents'][] = [
                    'id' => $rent->id,
                    'startDate' => $rent->start_date->format('Y-m-d'),
                    'name' => $rent->number . '/' . $rent->start_date->format('Y'),
                    'payed' => $rent->payed,
                    'price' => $rent->price
                ];
            }
        }

        /*
        ###########
        ## DIVES ##
        ###########
        */

        $dives = $user->rosters()->whereHas('roster', fn ($q) => $q->where('type', 'DIVE'))->get();
        $data['dives'] = [];
        if ($dives) {
            foreach ($dives as $dive) {
                $site = $dive->site;
                if (!isset($data['dives'][$site->id])) {
                    $data['dives'][$site->id] = [
                        'lat'  => $site->lat,
                        'long' => $site->long,
                        'name' => $site->name,
                        'count' => 1
                    ];
                } else
                    $data['dives'][$site->id]['count'] += 1;
            }
        }
        $data['dives'] = array_values($data['dives']);
        return response()->json(['data' => $data]);
    }

    private function caluculateProgress($array, &$completed, &$total)
    {

        foreach ($array as $idx => $item) {

            if (isset($item['values'])) {
                if (!isset($item['values'][0]['values'])) {

                    foreach ($item['values'] as $exercise) {
                        $total++;
                        if ($exercise['date']) {
                            $completed++;
                        }
                    }
                }
                $this->caluculateProgress($item['values'], $completed, $total);
            }
        }
    }
}
