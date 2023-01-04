<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CertificationResource;
use App\Models\Certification;
use Illuminate\Http\Request;

class CertificationController extends Controller
{
    public function indexAll(Request $request)
    {
        return CertificationResource::collection(Certification::orderBy('name')->get());
    }
    public function get(Request $request, Certification $certification)
    {
        return new CertificationResource($certification);
    }
}
