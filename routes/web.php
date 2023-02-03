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
    $testArrays = [
        [1 => true, 2 => false, 3 => false, 4 => false, 5 => false],
        [1 => false, 2 => false, 3 => false, 4 => false, 5 => false]
    ];

    $overallFound = 0;
    dump($testArrays);
    foreach ($testArrays as $testArray) {
        $found = 0;
        foreach ($testArray as $idx => $a) {
            if (!$a) {
                if ($idx > $overallFound)
                    $overallFound = $idx;
                $found  = $idx;
                $nextFound = false;
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
        dump($found);
    }
    return $overallFound;
});
Route::prefix('rosters')->group(function () {
    Route::get('print/{roster}', [RosterController::class, 'printTech']);
});

Route::prefix('rents')->group(function () {
    Route::get('print/{rent}', [RentController::class, 'printAgreement']);
});
