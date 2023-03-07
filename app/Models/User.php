<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Transformers\UserTransformer;
use Laratrust\Traits\LaratrustUserTrait;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id',

    ];
    public $transformer = UserTransformer::class;

    public function scopeSearch($query, $keyword, $columns)
    {
        if ($keyword) {
            foreach ($columns as $idx => $column) {
                if ($idx == 0)
                    $query->where($column, 'LIKE', '%' . $keyword . '%');
                else
                    $query->orWhere($column, 'LIKE', '%' . $keyword . '%');
            }
        }


        return $query;
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    /**
     * Get the user's name.
     *
     * @return string
     */
    public function getNameAttribute()
    {
        return "{$this->firstname} {$this->lastname}";
    }
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'birthdate' => 'datetime:Y-m-d',
        'dan_exp' => 'datetime:Y-m-d',
        'asd_membership' => 'boolean',
    ];

    public function equipments()
    {
        return $this->belongsToMany(Equipment::class)->withPivot(['size_id', 'number', 'owned'])->using(EquipmentUser::class);;
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class)->withPivot(['end_date', 'progress', 'price', 'teaching', 'in_charge', 'payment_1', 'payment_2', 'payment_3', 'payment_1_date', 'payment_2_date', 'payment_3_date', 'payed'])->using(CourseUser::class);;
    }

    public function unpayedCourses()
    {
        return $this->belongsToMany(Course::class)->withPivot(['end_date', 'progress', 'price', 'teaching', 'in_charge', 'payment_1', 'payment_2', 'payment_3', 'payment_1_date', 'payment_2_date', 'payment_3_date', 'payed'])->using(CourseUser::class)
            ->where(function (Builder $query) {
                $query->where('course_user.payed', '<>', 1)->where('course_user.teaching', '<>', 1)->where('course_user.price', '>', 0);
            });
    }
    public function openedCourses()
    {
        return $this->belongsToMany(Course::class)->withPivot(['end_date', 'progress', 'price', 'teaching', 'in_charge', 'payment_1', 'payment_2', 'payment_3', 'payment_1_date', 'payment_2_date', 'payment_3_date', 'payed'])->using(CourseUser::class)
            ->where(function (Builder $query) {
                $query->where('course_user.end_date', null);
            });
    }
    public function rosters()
    {
        return $this->belongsToMany(RosterDive::class, 'roster_user')->withPivot(['course_id', 'note', 'price', 'course_note', 'payed', 'gears'])->using(RosterUser::class);
    }
    public function unpayedRosters()
    {
        return $this->belongsToMany(RosterDive::class, 'roster_user')->withPivot(['course_id', 'note', 'price', 'course_note', 'payed', 'gears'])->using(RosterUser::class)
            ->where(function (Builder $query) {
                $query->where('roster_user.payed', '<>', 1)->where('roster_user.price', '>', 0);
            });
    }

    public function unpayedItems()
    {
        return count($this->unpayedCourses) || count($this->unpayedRents) || count($this->unpayedRosters) || !$this->asd_membership;
    }
    public function duty()
    {
        return $this->belongsTo(UserDuty::class, 'user_duty_id');
    }
    public function rents()
    {
        return $this->hasMany(Rent::class);
    }
    public function unpayedRents()
    {
        return $this->hasMany(Rent::class)
            ->where('payed', '<>', 1)->where('price', '>', 0);
    }
    public function openRents()
    {
        return $this->hasMany(Rent::class)
            ->where('return_date', null);
    }
    public function emergency_contact()
    {
        return $this->hasOne(UserEmergencycontact::class);
    }
    public function getDefaultSizes()
    {
        $sizes = null;
        $allSizes = Size::get();
        foreach ($this->equipments as $equipment) {

            $s = $equipment->pivot->toArray();
            unset($s['user_id']);
            $s['name'] = $equipment->name;
            $foundSize = $allSizes->firstWhere('id', $s['size_id']);
            $s['size'] = null;
            if (!$s['owned'])
                $s['size'] = $foundSize ? $foundSize->name : null;
            else {
                $s['size_id'] = null;
                $s['number'] = null;
            }
            $sizes[] = $s;
        }
        return $sizes;
    }

    public function getAvatarUrl()
    {
        if (!$this->avatar)
            $this->avatar = 'generic.png';
        $filePath = 'images/avatars/' . $this->avatar;
        return Storage::url($filePath);
    }
    public function getAvatarPath()
    {
        if (!$this->avatar)
            $this->avatar = 'generic.png';
        $filePath = 'images/avatars/' . $this->avatar;
        return storage_path('app/public/' . $filePath);
    }
}
