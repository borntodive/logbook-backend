<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Diving extends Model
{
    use HasFactory;
    protected $guarded = [
        'id',

    ];
    public function rosters()
    {
        return $this->hasMany(Roster::class);
    }

    public function sites()
    {
        return $this->belongsToMany(DiveSite::class)->orderBy('name');
    }
    public function getLogoUrl()
    {
        if (!$this->logo)
            $this->logo = 'generic.png';
        $filePath = 'images/divings/' . $this->logo;
        return Storage::url($filePath);
    }
}
