
<?php

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
        Schema::table('course_user', function (Blueprint $table) {
            $table->dateTime('payment_1_date')->nullable();
            $table->dateTime('payment_2_date')->nullable();
            $table->dateTime('payment_3_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('course_user', function (Blueprint $table) {
            $table->dropColumn('payment_1_date');
            $table->dropColumn('payment_2_date');
            $table->dropColumn('payment_3_date');
        });
    }
};
