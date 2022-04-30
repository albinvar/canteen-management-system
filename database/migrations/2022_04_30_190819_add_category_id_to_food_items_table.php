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
    public function up(): void
    {
        Schema::table('food_items', static function (Blueprint $table) {
            $table->foreignId('category_id')->after('id')->constrained('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('food_items', static function (Blueprint $table) {
            //delete foreign key
            $table->dropForeign(['category_id']);
            //delete column
            $table->dropColumn('category_id');
        });
    }
};
