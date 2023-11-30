<?php

use App\Modules\Order\Enums\OrderStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('payment_method');
            $table->float('price');
            $table->tinyInteger('status')->default(OrderStatus::CREATED->value);
            $table->foreignId('user_id')->constrained()->restrictOnDelete();
            $table->string('payment_link')->nullable();
            $table->text('payment_log')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
