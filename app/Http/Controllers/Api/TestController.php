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
use Illuminate\Support\Str;
use ZipArchive;
use File;
use mikehaertl\pdftk\Pdf;
use setasign\Fpdi\Fpdi;

class TestController extends Controller
{

    public function srf(Request $request)
    {
        $path = storage_path('app/public/student_records/OWD.pdf');
        $user = User::find(1);
        $tempFile = Str::uuid() . '.pdf';
        $pdfForm = new Pdf($path);

        $result = $pdfForm->fillForm([
            'line_1' => 'AC',
        ])
            ->flatten()
            ->saveAs(storage_path('app/public/student_records/temp/' . $tempFile));
        // Always check for errors
        if ($result === false) {
            $error = $pdfForm->getError();
            dd($error);
        }
        $pdf = new Fpdi();
        // set the source file
        $pageCount = $pdf->setSourceFile(storage_path('app/public/student_records/temp/' . $tempFile));

        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            // import a page
            $templateId = $pdf->importPage($pageNo);

            $pdf->AddPage();
            // use the imported page and adjust the page size
            $pdf->useTemplate($templateId, ['adjustPageSize' => true]);
            $pdf->Image($user->getAvatarPath(), 12, 4, 22, 22);
        }

        $pdf->Output();
        /*

        return 'pippo'; */
    }
    public function mail(Request $request)
    {
        $user = User::find(2);
        $password = 'pippo';
        Mail::to($user->email)->send(new ForgotPssword($user, $password));

        return 'done';
    }
}
