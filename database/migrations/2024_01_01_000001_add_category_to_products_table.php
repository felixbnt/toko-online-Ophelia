<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('products')) {
            Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->integer('price')->default(0);
                $table->integer('stock')->default(0);
                $table->enum('category', ['man', 'woman', 'kids'])->default('man');
                $table->timestamps();
            });
        } else {
            if (!Schema::hasColumn('products', 'category')) {
                Schema::table('products', function (Blueprint $table) {
                    $table->enum('category', ['man', 'woman', 'kids'])->default('man')->after('stock');
                });
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('products')) {
            if (Schema::hasColumn('products', 'category')) {
                Schema::table('products', function (Blueprint $table) {
                    $table->dropColumn('category');
                });
            }
        }
    }
};