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

        Schema::create('sales', function (Blueprint $table) {

            $table -> id();

            $table -> unsignedBigInteger('id_product');

            $table -> foreign('id_product') -> references('id') -> on('products') -> onDelete('cascade');

            $table -> unsignedBigInteger('id_subproduct') -> nullable();

            $table -> foreign('id_subproduct') -> references('id') -> on('subproducts') -> onDelete('cascade');

            $table -> unsignedBigInteger('id_user');

            $table -> foreign('id_user') -> references('id') -> on('users') -> onDelete('cascade');

            $table -> integer('quantity');

            $table -> enum('method', array('WEB','MOBILE','LOCAL'));

            $table -> tinyInteger('status');

            $table -> timestamps();

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
