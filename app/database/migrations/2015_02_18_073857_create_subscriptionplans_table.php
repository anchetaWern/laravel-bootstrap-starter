<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionplansTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('subscription_plans', function($table){
            $table->increments('id');
            $table->string('name', 50);
            $table->double('price');
            $table->char('period', 10);
            $table->string('stripe_plan_id', 50);
            $table->text('features');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('subscription_plans');
	}

}
