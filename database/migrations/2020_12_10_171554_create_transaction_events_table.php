<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id');
            $table->foreign('member_id')->references('id')->on('event_members')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('event_id');
            $table->foreign('event_id')->references('id')->on('events')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->integer('quantity');

            $table->unsignedBigInteger('promo_id')->nullable();
            $table->foreign('promo_id')->references('id')->on('promos')
                ->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('transaction_events');
    }
}
