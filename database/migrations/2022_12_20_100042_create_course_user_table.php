<?php

use App\Models\Course;
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
        Schema::create('course_user', function (Blueprint $table) {
            $table->foreignIdFor(Course::class);
            $table->foreignIdFor(User::class);
            $table->float('price')->nullable();
            $table->float('payment_1')->nullable();
            $table->float('payment_2')->nullable();
            $table->float('payment_3')->nullable();
            $table->date('end_date')->nullable();
            $table->json('progress')->nullable();
            $table->boolean('teaching')->default(false);
            $table->boolean('in_charge')->default(false);
            $table->timestamps();
            $table->primary(['course_id','user_id']);
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
