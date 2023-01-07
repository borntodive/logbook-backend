<?php

use App\Models\Diving;
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
        Schema::create('rosters', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date');
            $table->foreignIdFor(Diving::class);
            $table->string('note')->nullable();
            $table->float('cost')->nullable();
            $table->float('price')->nullable();
            $table->string('type')->default('POOL');
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
        Schema::dropIfExists('rosters');
    }
};
