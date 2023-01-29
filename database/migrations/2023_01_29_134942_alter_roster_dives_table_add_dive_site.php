<?php

use App\Models\DiveSite;
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
        Schema::table('roster_dives', function (Blueprint $table) {
            $table->foreignIdFor(DiveSite::class)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('roster_dives', function (Blueprint $table) {
            $table->dropColumn('dive_site_id');
        });
    }
};
