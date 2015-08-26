<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedbacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->increments('id');

            $table->enum('feedback', ['positive', 'neutral', 'negative',]);
            $table->text('review');

            $table->integer('sender_id')->unsigned();
            $table->foreign('sender_id')->references('id')->on('users');

            $table->integer('receiver_id')->unsigned();
            $table->foreign('receiver_id')->references('id')->on('users');

            $table->integer('order_id')->unsigned();
            $table->foreign('order_id')->references('id')->on('orders');

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
        Schema::drop('feedbacks');
    }
}
