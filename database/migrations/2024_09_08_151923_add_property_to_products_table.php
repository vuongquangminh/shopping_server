<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPropertyToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            //
            $table->string('camera')->nullable();
            $table->foreignId('chip_id')->constrained('chips')->onDelete('cascade');
            $table->string('man_hinh')->nullable();
            $table->foreignId('dung_luong_id')->constrained('dung_luongs')->onDelete('cascade');
            $table->string('bao_mat')->nullable();
            $table->foreignId('mau_sac_id')->constrained('mau_sacs')->onDelete('cascade');
            $table->string('pin')->nullable();
            $table->string('chong_nuoc')->nullable();
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
            // Xóa các ràng buộc khóa ngoại
            $table->dropForeign(['chip_id']);
            $table->dropForeign(['dung_luong_id']);
            $table->dropForeign(['mau_sac_id']);

            // Xóa các cột
            $table->dropColumn([
                'camera',
                'chip_id',
                'man_hinh',
                'dung_luong_id',
                'bao_mat',
                'mau_sac_id',
                'pin',
                'chong_nuoc'
            ]);
        });
    }
}
