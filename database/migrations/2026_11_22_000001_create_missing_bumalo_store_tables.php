<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tabel master
        if (! Schema::hasTable('brands')) {
            Schema::create('brands', function (Blueprint $table) {
                $table->id(); $table->string('name')->unique(); $table->timestamps();
            });
        }
        if (! Schema::hasTable('categories')) {
            Schema::create('categories', function (Blueprint $table) {
                $table->id(); $table->string('name')->unique(); $table->timestamps();
            });
        }

        // 2. Kolom tambahan di tabel products (tabel ini sudah ada dari migration toko)
        if (! Schema::hasTable('products')) {
            Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->foreignId('brand_id')->constrained()->cascadeOnDelete();
                $table->foreignId('category_id')->constrained()->cascadeOnDelete();
                $table->string('name'); $table->string('slug')->unique();
                $table->text('description')->nullable(); $table->unsignedInteger('price');
                $table->string('image')->nullable(); $table->boolean('is_active')->default(true)->index();
                $table->timestamps();
            });
        } else {
            Schema::table('products', function (Blueprint $table) {
                if (! Schema::hasColumn('products', 'brand_id')) { $table->unsignedBigInteger('brand_id')->nullable()->index(); }
                if (! Schema::hasColumn('products', 'category_id')) { $table->unsignedBigInteger('category_id')->nullable()->index(); }
                if (! Schema::hasColumn('products', 'slug')) { $table->string('slug')->nullable()->unique(); }
                if (! Schema::hasColumn('products', 'description')) { $table->text('description')->nullable(); }
                if (! Schema::hasColumn('products', 'image')) { $table->string('image')->nullable(); }
                if (! Schema::hasColumn('products', 'is_active')) { $table->boolean('is_active')->default(true)->index(); }
            });
        }

        // 3. Tabel turunan
        if (! Schema::hasTable('product_variants')) {
            Schema::create('product_variants', function (Blueprint $table) {
                $table->id(); $table->foreignId('product_id')->constrained()->cascadeOnDelete();
                $table->string('size', 8); $table->string('sku')->unique(); $table->unsignedInteger('stock')->default(0);
                $table->timestamps(); $table->unique(['product_id', 'size']);
            });
        }
        if (! Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $table) {
                $table->id(); $table->string('code', 24)->unique();
                $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
                $table->string('customer_name'); $table->string('email')->nullable(); $table->string('phone');
                $table->text('address'); $table->string('city'); $table->string('postal_code', 12)->nullable();
                $table->unsignedInteger('subtotal'); $table->unsignedInteger('shipping_cost')->default(0);
                $table->unsignedInteger('total'); $table->string('status')->default('pending_payment')->index();
                $table->timestamp('payment_due_at')->nullable(); $table->text('admin_note')->nullable();
                $table->timestamps();
            });
        }
        if (! Schema::hasTable('order_items')) {
            Schema::create('order_items', function (Blueprint $table) {
                $table->id(); $table->foreignId('order_id')->constrained()->cascadeOnDelete();
                $table->foreignId('variant_id')->nullable()->constrained('product_variants')->nullOnDelete();
                $table->string('product_name'); $table->string('size', 8); $table->unsignedInteger('price');
                $table->unsignedInteger('quantity'); $table->timestamps();
            });
        }
        if (! Schema::hasTable('payments')) {
            Schema::create('payments', function (Blueprint $table) {
                $table->id(); $table->foreignId('order_id')->constrained()->cascadeOnDelete();
                $table->string('proof_path')->nullable(); $table->unsignedInteger('amount');
                $table->string('status')->default('unsubmitted')->index();
                $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
                $table->text('note')->nullable(); $table->timestamp('verified_at')->nullable(); $table->timestamps();
            });
        }
        if (! Schema::hasTable('shipments')) {
            Schema::create('shipments', function (Blueprint $table) {
                $table->id(); $table->foreignId('order_id')->unique()->constrained()->cascadeOnDelete();
                $table->string('courier')->nullable(); $table->string('tracking_number')->nullable();
                $table->timestamp('shipped_at')->nullable(); $table->timestamps();
            });
        }
        if (! Schema::hasTable('stock_movements')) {
            Schema::create('stock_movements', function (Blueprint $table) {
                $table->id(); $table->foreignId('variant_id')->constrained('product_variants')->cascadeOnDelete();
                $table->integer('change'); $table->string('reason');
                $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); $table->timestamps();
            });
        }
        if (! Schema::hasTable('order_status_logs')) {
            Schema::create('order_status_logs', function (Blueprint $table) {
                $table->id(); $table->foreignId('order_id')->constrained()->cascadeOnDelete();
                $table->string('status'); $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
                $table->text('note')->nullable(); $table->timestamps();
            });
        }

        // 4. Hubungkan produk toko yang sudah ada ke brand dan category
        $now = now();
        $brandOf = function (string $name) use ($now) {
            return DB::table('brands')->where('name', $name)->value('id')
                ?? DB::table('brands')->insertGetId(['name' => $name, 'created_at' => $now, 'updated_at' => $now]);
        };
        $catOf = function (string $name) use ($now) {
            return DB::table('categories')->where('name', $name)->value('id')
                ?? DB::table('categories')->insertGetId(['name' => $name, 'created_at' => $now, 'updated_at' => $now]);
        };

        if (Schema::hasColumn('products', 'brand') && Schema::hasColumn('products', 'type')) {
            foreach (DB::table('products')->whereNotNull('brand')->distinct()->pluck('brand') as $b) {
                DB::table('products')->where('brand', $b)->whereNull('brand_id')->update(['brand_id' => $brandOf($b)]);
            }
            $cats = ['pria' => 'Pria', 'wanita' => 'Wanita', 'anak' => 'Anak-anak'];
            foreach ($cats as $key => $label) {
                DB::table('products')->where('type', 'sepatu')->where('gender', $key)->whereNull('category_id')->update(['category_id' => $catOf($label)]);
            }
            DB::table('products')->where('type', 'accessory')->whereNull('category_id')->update(['category_id' => $catOf('Accessories')]);
        }

        foreach (DB::table('products')->whereNull('slug')->get(['id', 'name']) as $p) {
            DB::table('products')->where('id', $p->id)->update(['slug' => Str::slug($p->name) . '-' . $p->id]);
        }
    }

    public function down(): void
    {
        foreach (['order_status_logs', 'stock_movements', 'shipments', 'payments', 'order_items', 'orders', 'product_variants', 'categories'] as $t) {
            Schema::dropIfExists($t);
        }
    }
};