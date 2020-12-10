<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_products', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->unsignedBigInteger('organizer_id');
            $table->foreign('organizer_id')->references('id')->on('organizers')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });

        Schema::create('transaction_product_details', function (Blueprint $table) {
            $table->unsignedBigInteger('transaction_id');
            $table->foreign('transaction_id')->references('id')->on('transaction_products')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->string('product_name');
            $table->string('quantity');
            $table->string('product_price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_products');
    }
}
