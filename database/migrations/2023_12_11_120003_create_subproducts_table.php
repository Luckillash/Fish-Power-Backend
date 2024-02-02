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

        Schema::create('subproducts', function (Blueprint $table) {

            $table -> id();

            $table -> unsignedBigInteger('id_product');

            $table -> foreign('id_product') -> references('id') -> on('products') -> onDelete('cascade');

            $table -> string('subproduct');

            $table -> string('price');

            $table -> string('img') -> nullable();

            $table -> timestamps();

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subproducts');
    }
};
