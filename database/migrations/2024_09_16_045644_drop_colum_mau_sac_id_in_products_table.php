<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumMauSacIdInProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('mau_sac_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('mau_sac_id')->nullable();

            // Khôi phục lại ràng buộc khóa ngoại (nếu có)
            $table->foreign('mau_sac_id')->references('id')->on('mau_sacs')->onDelete('cascade');
        });
    }
}
