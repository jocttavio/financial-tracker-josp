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
        Schema::create('products_services', function (Blueprint $table) {
            $table->id('id_product_service');
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id('id_category');
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('accounts', function (Blueprint $table) {
            $table->id('id_account');
            $table->string('name');
            $table->string('type');
            $table->decimal('current_balance', 10, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('revenue', function (Blueprint $table) {
            $table->id('id_revenue');
            $table->decimal('amount', 10, 2);
            $table->string('description')->nullable();
            $table->date('date');
            $table->timestamps();
            $table->unsignedBigInteger('account_id');
            $table->unsignedBigInteger('category_id');

            $table->foreign('account_id')->references('id_account')->on('accounts')->onDelete('cascade');
            $table->foreign('category_id')->references('id_category')->on('categories')->onDelete('cascade');
            $table->softDeletes();
        });

        Schema::create('expenses', function (Blueprint $table) {
            $table->id('id_expense');
            $table->decimal('amount', 10, 2);
            $table->string('description')->nullable();
            $table->string('payment_method')->nullable();
            $table->date('date');
            $table->timestamps();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('product_service_id')->nullable();

            $table->foreign('category_id')->references('id_category')->on('categories')->onDelete('cascade');
            $table->foreign('product_service_id')->references('id_product_service')->on('products_services')->onDelete('cascade');
            $table->softDeletes();
        });

        Schema::create('movements_account_history', function (Blueprint $table) {
            $table->id('id_movement');
            $table->decimal('amount', 10, 2);
            $table->string('type'); // 'revenue' or 'expense'
            $table->date('date');
            $table->integer('reference_id'); // ID of the related revenue or expense
            $table->timestamps();
            $table->unsignedBigInteger('account_id');

            $table->foreign('account_id')->references('id_account')->on('accounts')->onDelete('cascade');
            $table->softDeletes();
        });

        Schema::create('debts', function (Blueprint $table) {
            $table->id('id_debt');
            $table->decimal('amount', 10, 2);
            $table->string('description')->nullable();
            $table->date('due_date');
            $table->timestamps();
            $table->unsignedBigInteger('account_id');

            $table->foreign('account_id')->references('id_account')->on('accounts')->onDelete('cascade');
            $table->softDeletes();
        });

        Schema::create('transactions', function (Blueprint $table) {
            $table->id('id_transaction');
            $table->text('description')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('place')->nullable();
            $table->date('date');
            $table->unsignedBigInteger('account_id');

            $table->foreign('account_id')->references('id_account')->on('accounts')->onDelete('cascade');
            $table->softDeletes();
        });

        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id('id_transaction_detail');
            $table->decimal('amount', 10, 2)->after('id_transaction_detail');
            $table->decimal('unit_price', 10, 2)->after('amount');
            $table->decimal('subtotal', 10, 2)->after('unit_price');
            $table->unsignedBigInteger('product_service_id')->after('id_transaction_detail');
            $table->unsignedBigInteger('category_id')->after('product_service_id');
            $table->unsignedBigInteger('transaction_id')->after('category_id');


            $table->foreign('product_service_id')->references('id_product_service')->on('products_services')->onDelete('cascade');
            $table->foreign('category_id')->references('id_category')->on('categories')->onDelete('cascade');
            $table->foreign('transaction_id')->references('id_transaction')->on('transactions')->onDelete('cascade');
            $table->softDeletes();
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id('id_payment');
            $table->decimal('amount', 10, 2)->after('id_payment');
            $table->string('payment_method')->nullable();
            $table->date('date');

            $table->unsignedBigInteger('origin_account_id');
            $table->unsignedBigInteger('transaction_id');
            $table->unsignedBigInteger('debt_id')->nullable();


            $table->foreign('origin_account_id')->references('id_account')->on('accounts')->onDelete('cascade');
            $table->foreign('transaction_id')->references('id_transaction')->on('transactions')->onDelete('cascade');
            $table->foreign('debt_id')->references('id_debt')->on('debts')->onDelete('cascade');
            $table->softDeletes();
        });

        Schema::create('savings', function (Blueprint $table) {
            $table->id('id_saving');
            $table->string('name')->after('id_saving');
            $table->string('description')->nullable();
            $table->decimal('objective_amount', 10, 2)->after('id_saving');
            $table->decimal('current_amount', 10, 2)->after('objective_amount');
            $table->date('limit_date');

            $table->unsignedBigInteger('account_id');

            $table->foreign('account_id')->references('id_account')->on('accounts')->onDelete('cascade');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movements_account_history');
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('revenue');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('transaction_details');
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('debts');
        Schema::dropIfExists('products_services');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('savings');
        Schema::dropIfExists('accounts');
    }
};
