<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'user_id'))
                $table->unsignedBigInteger('user_id')->nullable()->after('id');

            if (!Schema::hasColumn('orders', 'order_number'))
                $table->string('order_number')->unique()->after('user_id');

            if (!Schema::hasColumn('orders', 'name'))
                $table->string('name')->nullable()->after('order_number');

            if (!Schema::hasColumn('orders', 'email'))
                $table->string('email')->nullable()->after('name');

            if (!Schema::hasColumn('orders', 'phone'))
                $table->string('phone')->nullable()->after('email');

            if (!Schema::hasColumn('orders', 'address'))
                $table->text('address')->nullable()->after('phone');

            if (!Schema::hasColumn('orders', 'city'))
                $table->string('city')->nullable()->after('address');

            if (!Schema::hasColumn('orders', 'payment_method'))
                $table->string('payment_method')->after('city');

            if (!Schema::hasColumn('orders', 'subtotal'))
                $table->bigInteger('subtotal')->default(0)->after('payment_method');

            if (!Schema::hasColumn('orders', 'ongkir'))
                $table->bigInteger('ongkir')->default(0)->after('subtotal');

            if (!Schema::hasColumn('orders', 'grand_total'))
                $table->bigInteger('grand_total')->default(0)->after('ongkir');

            if (!Schema::hasColumn('orders', 'status'))
                $table->string('status')->default('pending')->after('grand_total');
        });

        // Tambah foreign key hanya jika belum ada
        try {
            Schema::table('orders', function (Blueprint $table) {
                $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            });
        } catch (\Exception $e) {
            // Foreign key sudah ada, skip
        }
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            try { $table->dropForeign(['user_id']); } catch (\Exception $e) {}
            $columns = ['order_number', 'name', 'email', 'phone', 'address',
                        'city', 'payment_method', 'subtotal', 'ongkir', 'grand_total', 'status'];
            foreach ($columns as $col) {
                if (Schema::hasColumn('orders', $col)) $table->dropColumn($col);
            }
        });
    }
};