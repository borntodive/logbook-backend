<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ASDMembership;
use App\Mail\ForgotPssword;
use App\Mail\HappyBirthday;
use App\Mail\UserCreated;
use App\Models\Document;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use File;

class TestController extends Controller
{

    public function mail(Request $request)
    {
        $user = User::find(2);
        $password = 'pippo';
        Mail::to($user->email)->send(new ForgotPssword($user, $password));

        return 'done';
    }
}
