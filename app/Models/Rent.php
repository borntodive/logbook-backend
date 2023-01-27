<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    use HasFactory;
    protected $guarded = [
        'id',

    ];
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($rent) { // before delete() method call this
            $rent->equipments()->delete();
            // do the rest of the cleanup...
        });
    }
    protected $casts = [
        'start_date' => 'datetime:Y-m-d',
        'end_date' => 'datetime:Y-m-d',
        'return_date' => 'datetime:Y-m-d',
        'payed' => 'boolean',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function equipments()
    {
        return $this->hasMany(RentEquipment::class);
    }
}
