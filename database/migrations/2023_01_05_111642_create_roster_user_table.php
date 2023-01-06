<?php

use App\Models\Course;
use App\Models\Roster;
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
        Schema::create('roster_user', function (Blueprint $table) {
            $table->foreignIdFor(Roster::class);
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Course::class)->nullable();
            $table->string('note')->nullable();
            $table->string('course_note')->nullable();
            $table->float('price')->nullable();
            $table->boolean('payed')->default(false);
            $table->boolean('staff')->default(false);
            $table->json('gears')->nullable();
            $table->timestamps();
            $table->primary(['roster_id', 'user_id']);
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
