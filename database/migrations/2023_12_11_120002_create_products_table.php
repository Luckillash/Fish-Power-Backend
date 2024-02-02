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

        Schema::create('products', function (Blueprint $table) {

            $table -> id();

            $table -> unsignedBigInteger('id_subtype');

            $table -> foreign('id_subtype') -> references('id') -> on('subtypes') -> onDelete('cascade');

            $table -> string('product');

            $table -> string('img') -> nullable();

            $table -> integer('price');

            $table -> tinyInteger('cliente');

            $table -> tinyInteger('proveedor');

            $table -> timestamps();

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
