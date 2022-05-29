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
        Schema::create('cargo_bills', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('charge_id')->nullable()->index();
            $table->timestamps();

            $table->foreign('charge_id')
                ->references('id')->on('cargo_charges')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cargo_bills');
    }
};
