<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Transformers\UserTransformer;
class User extends Authenticatable
{
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

    public function scopeSearch($query, $keyword,$columns)
    {
        if ($keyword)
        {
            foreach ($columns as $idx=>$column) {
            if($idx==0)
             $query->where($column, 'LIKE', '%'.$keyword.'%');
             else
             $query->orWhere($column, 'LIKE', '%'.$keyword.'%');
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
        return $this->belongsToMany(Equipment::class)->withPivot(['size_id','number']);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class)->withPivot(['end_date','progress','price','teaching','in_charge']);
    }
     public function duty()
    {
        return $this->belongsTo(UserDuty::class,'user_duty_id');
    }
}
