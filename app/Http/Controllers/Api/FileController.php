<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use File;

class FileController extends Controller
{

    public function upload(Request $request)
    {
        $path = public_path('tmp/uploads');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $file = $request->file('file');

        $name = uniqid() . '.' . trim($file->getClientOriginalExtension());
        $path = $request->file('file')->storeAs(
            'tmp',
            $name
        );

        return response()->json(['name' => $name]);
    }
}
