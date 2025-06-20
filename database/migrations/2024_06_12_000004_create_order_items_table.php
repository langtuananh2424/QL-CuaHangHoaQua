<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('fruit_id');
            $table->integer('quantity');
            $table->timestamps();
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('fruit_id')->references('id')->on('fruits');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
