
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_variants', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('store_id')
                ->constrained()
                ->restrictOnDelete();

            $table->foreignId('product_id')
                ->constrained()
                ->restrictOnDelete();

            $table->string('sku');

            $table->string('name')->nullable();
            $table->json('attributes')->nullable();

            $table->decimal('price', 12, 2);
            $table->decimal('cost', 12, 2)->nullable();

            $table->decimal('shipping_fee_per_unit', 12, 2)->nullable();

            $table->string('status');

            $table->timestamps();

            $table->unique(['store_id', 'sku']);
            $table->index(['store_id', 'product_id']);
            $table->index(['store_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
