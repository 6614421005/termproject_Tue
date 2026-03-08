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
        Schema::create('cards', function (Blueprint $table) {
        $table->id();
        $table->string('card_name');                // 1
        $table->string('game_system');              // 2
        $table->string('card_set');                 // 3
        $table->string('card_number');              // 4
        $table->string('rarity');                   // 5
        $table->string('condition');                // 6
        $table->string('language');                 // 7
        $table->string('card_type');                // 8
        $table->string('main_attribute');           // 9
        $table->string('grade_cost');               // 10
        $table->string('power_stats')->nullable();  // 11 (อนุญาตให้ว่างได้ เพราะบางการ์ดไม่มีค่าพลัง)
        $table->decimal('selling_price', 10, 2);    // 12
        $table->integer('stock_quantity');          // 13
        $table->string('status')->default('available'); // 14
        $table->text('description')->nullable();    // 15
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
