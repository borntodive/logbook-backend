<?php

use App\Http\Controllers\Api\RentController;
use App\Http\Controllers\Api\RosterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/test', function () {
    $testArray = [1 => false, 2 => false, 3 => false, 4 => false, 5 => false];
    $found = 0;
    dump($testArray);
    foreach ($testArray as $idx => $a) {
        if (!$a) {
            $found = $idx;
            $nextFound = false;
            dump($idx);
            foreach (array_slice($testArray, $idx + 1) as $idn => $next) {
                if ($next) {
                    $nextFound = true;
                    $found = 0;
                }
            }
            if (!$nextFound)
                break;
        }
    }
    return $found;
});
Route::prefix('rosters')->group(function () {
    Route::get('print/{roster}', [RosterController::class, 'printTech']);
});

Route::prefix('rents')->group(function () {
    Route::get('print/{rent}', [RentController::class, 'printAgreement']);
});
