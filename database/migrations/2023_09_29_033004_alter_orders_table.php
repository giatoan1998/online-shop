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
        Schema::table('orders', function(Blueprint $table) {
            $table->enum('payment_status', ['paid', 'not paid'])->after('grand_total')->default('not paid');
            $table->enum('status', ['pending', 'shipped', 'delivered'])->after('payment_status')->default('pending');
            $table->string('coupon_code_id')->nullable()->after('coupon_code')->nullable();
            $table->string('coupon_code')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function(Blueprint $table) {
            $table->dropColumn('payment_status');
            $table->dropColumn('status');
            $table->dropColumn('coupon_code_id');
            $table->double('coupon_code', 8, 2)->change();
        });
    }
};
