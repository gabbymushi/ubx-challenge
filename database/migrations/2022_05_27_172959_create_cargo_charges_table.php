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
        Schema::create('cargo_charges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cargo_id')->nullable()->index();
            $table->enum('category', ['wharfage', 'storage', 'destuffing', 'lifting'])->index();
            $table->double('amount');
            $table->double('eletricity_amount')->nullable();
            $table->integer('penalty_days')->nullable();
            $table->timestamps();

            $table->foreign('cargo_id')
                ->references('id')->on('cargos')
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
        Schema::dropIfExists('cargo_charges');
    }
};
