<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('SellerDelivered')->default(0); //Step 2
            $table->boolean('BuyerCancelRequest')->default(0); //Step 2
            $table->boolean('BuyerChecked')->default(0); //Step 3

            $table->boolean('paid')->default(0); //Step4

            $table->boolean('BuyerSentFeedback')->default(0); //Step5
            $table->boolean('SellerSentFeedback')->default(0); //Step5


            $table->boolean('closed')->default(0);

            $table->boolean('needAdmin')->default(0);
            $table->string('reason')->nullable();

            $table->integer('user_id')->unsigned(); //buyer
            $table->foreign('user_id')->references('id')->on('users');

            $table->integer('seller_user_id')->unsigned(); //seller
            $table->foreign('seller_user_id')->references('id')->on('users');

            $table->integer('account_id')->unsigned();
            $table->foreign('account_id')->references('id')->on('accounts');

            $table->string('payKey');
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
        Schema::drop('orders');
    }
}
