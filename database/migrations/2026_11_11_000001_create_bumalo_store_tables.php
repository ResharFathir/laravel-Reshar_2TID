<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    private function make(string $name, Closure $callback): void
    {
        if (! Schema::hasTable($name)) {
            Schema::create($name, $callback);
        }
    }

    public function up(): void
    {
        
       if (! Schema::hasColumn('users', 'phone')) {
    Schema::table('users', function (Blueprint $table) {
        $table->string('phone')->nullable();
    });
}

if (! Schema::hasColumn('users', 'role')) {
    Schema::table('users', function (Blueprint $table) {
        $table->string('role')->default('customer')->index();
    });
}
        $this->make('brands', function (Blueprint $table) {
            $table->id(); $table->string('name')->unique(); $table->timestamps();
        });
       $this->make('brands', function (Blueprint $table) {
            $table->id(); $table->string('name')->unique(); $table->timestamps();
        });
        $this->make('brands', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('name'); $table->string('slug')->unique();
            $table->text('description')->nullable(); $table->unsignedInteger('price');
            $table->string('image')->nullable(); $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });
        $this->make('brands', function (Blueprint $table) {
            $table->id(); $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('size', 8); $table->string('sku')->unique(); $table->unsignedInteger('stock')->default(0);
            $table->timestamps(); $table->unique(['product_id', 'size']);
        });
        $this->make('brands', function (Blueprint $table) {
            $table->id(); $table->string('code', 24)->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('customer_name'); $table->string('email')->nullable(); $table->string('phone');
            $table->text('address'); $table->string('city'); $table->string('postal_code', 12)->nullable();
            $table->unsignedInteger('subtotal'); $table->unsignedInteger('shipping_cost')->default(0);
            $table->unsignedInteger('total'); $table->string('status')->default('pending_payment')->index();
            $table->timestamp('payment_due_at')->nullable(); $table->text('admin_note')->nullable();
            $table->timestamps();
        });
       $this->make('brands', function (Blueprint $table) {
            $table->id(); $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('variant_id')->nullable()->constrained('product_variants')->nullOnDelete();
            $table->string('product_name'); $table->string('size', 8); $table->unsignedInteger('price');
            $table->unsignedInteger('quantity'); $table->timestamps();
        });
        $this->make('brands', function (Blueprint $table) {
            $table->id(); $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->string('proof_path')->nullable(); $table->unsignedInteger('amount');
            $table->string('status')->default('unsubmitted')->index();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('note')->nullable(); $table->timestamp('verified_at')->nullable(); $table->timestamps();
        });
        $this->make('brands', function (Blueprint $table) {
            $table->id(); $table->foreignId('order_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('courier')->nullable(); $table->string('tracking_number')->nullable();
            $table->timestamp('shipped_at')->nullable(); $table->timestamps();
        });
        $this->make('brands', function (Blueprint $table) {
            $table->id(); $table->foreignId('variant_id')->constrained('product_variants')->cascadeOnDelete();
            $table->integer('change'); $table->string('reason');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); $table->timestamps();
        });
        $this->make('brands', function (Blueprint $table) {
            $table->id(); $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->string('status'); $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->text('note')->nullable(); $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_status_logs'); Schema::dropIfExists('stock_movements');
        Schema::dropIfExists('shipments'); Schema::dropIfExists('payments'); Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders'); Schema::dropIfExists('product_variants'); Schema::dropIfExists('products');
        Schema::dropIfExists('categories'); Schema::dropIfExists('brands');
        Schema::table('users', function (Blueprint $table) { $table->dropColumn(['phone', 'role']); });
    }
};
