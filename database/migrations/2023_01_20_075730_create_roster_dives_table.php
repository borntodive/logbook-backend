<?php

use App\Models\Roster;
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
        Schema::create('roster_dives', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Roster::class);

            $table->dateTime('date');
            $table->string('note')->nullable();
            $table->float('cost')->nullable();
            $table->float('price')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roster_dives');
    }
};
