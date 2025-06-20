<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->decimal('total_amount', 10, 2);
            $table->decimal('final_amount', 10, 2);
            $table->enum('status', ['pending', 'completed', 'cancelled']);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
