<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id('VentaID');
            $table->unsignedInteger('ProductoID');
            $table->integer('cantidad');
            $table->integer('precio_total');
            $table->timestamps();

            $table->foreign('ProductoID')
                    ->references('ProductoID')
                    ->on('productos')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
