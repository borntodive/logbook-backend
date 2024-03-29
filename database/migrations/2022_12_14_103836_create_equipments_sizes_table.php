<?php

use App\Models\Equipment;
use App\Models\Size;
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
        Schema::create('equipment_size', function (Blueprint $table) {
            $table->foreignIdFor(Equipment::class);
            $table->foreignIdFor(Size::class)->nullable();

            $table->integer('number')->nullable();
            $table->timestamps();
            $table->primary(['equipment_id', 'size_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipments_sizes');
    }
};
