<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Transformers\UserTransformer;
use Laratrust\Traits\LaratrustUserTrait;

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
    ];

    public function equipments()
    {
        return $this->belongsToMany(Equipment::class)->withPivot(['size_id', 'number', 'owned'])->using(EquipmentUser::class);;
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class)->withPivot(['end_date', 'progress', 'price', 'teaching', 'in_charge', 'payment_1', 'payment_2', 'payment_3'])->using(CourseUser::class);;
    }

    public function rosters()
    {
        return $this->belongsToMany(Roster::class)->withPivot(['course_id', 'note', 'price', 'course_note', 'payed', 'gears'])->using(RosterUser::class);
    }
    public function duty()
    {
        return $this->belongsTo(UserDuty::class, 'user_duty_id');
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
            $s['size'] = $foundSize ? $foundSize->name : null;
            $sizes[] = $s;
        }
        return $sizes;
    }
}
