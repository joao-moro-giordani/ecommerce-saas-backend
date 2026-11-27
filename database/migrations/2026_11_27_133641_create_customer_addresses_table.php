<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_addresses', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('store_id')->constrained()->restrictOnDelete();
            $table->unsignedBigInteger('customer_id');

            $table->string('label')->nullable();
            $table->string('recipient_name');
            $table->string('phone')->nullable();

            $table->string('postal_code');
            $table->string('country_code', 2)->default('BR');
            $table->string('state');
            $table->string('city');
            $table->string('district');
            $table->string('street');
            $table->string('number');
            $table->string('complement')->nullable();
            $table->string('reference')->nullable();

            $table->boolean('is_default')->default(false);

            $table->timestamps();
            $table->softDeletes();

            $table->index(['store_id', 'customer_id']);
            $table->index(['store_id', 'postal_code']);

            $table->foreign(['customer_id', 'store_id'])
                ->references(['id', 'store_id'])
                ->on('customers')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_addresses');
    }
};