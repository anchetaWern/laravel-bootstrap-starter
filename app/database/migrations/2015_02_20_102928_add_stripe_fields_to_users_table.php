<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStripeFieldsToUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function($table){
            $table->integer('subscription_planid');
            $table->string('stripe_customer_id');
            $table->string('stripe_subscription_id');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('users', function($table){
            $table->dropColumn('subscription_planid');
            $table->dropColumn('stripe_customer_id');
            $table->dropColumn('stripe_subscription_id');
        });
	}

}
