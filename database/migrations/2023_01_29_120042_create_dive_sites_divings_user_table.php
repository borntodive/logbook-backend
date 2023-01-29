<?php

use App\Models\Course;
use App\Models\DiveSite;
use App\Models\Diving;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dive_site_diving', function (Blueprint $table) {
            $table->foreignIdFor(Diving::class);
            $table->foreignIdFor(DiveSite::class);

            $table->primary(['diving_id', 'dive_site_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_user');
    }
};
