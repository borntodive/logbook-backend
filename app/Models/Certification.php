<?php

namespace App\Models;

use App\Casts\Json;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;

class Certification extends Model
{
    use HasFactory;
    protected $guarded = [
        'id',
    ];
    protected $casts = [
        'activities' => Json::class,
        'is_speciality' => 'boolean',
        'own_speciality' => 'boolean'
    ];
    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function scopeSpecialities($query)
    {
        return $query->where('is_speciality', true);
    }
}
