<?php
class SubscriptionPlansTableSeeder extends Seeder {

    public function run()
    {

        $plans = array(
            array(
                'name' => 'Basic',
                'price' => 12,
                'period' => 'month',
                'stripe_plan_id' => 'l4rb-basic',
                'features' => json_encode(array(
                    'Up to 12 Clients',
                    'Up to 3 Services',
                    'Email Notifications',
                    'Phone Support',
                    '&nbsp;'
                ))
            ),
            array(
                'name' => 'Pro',
                'price' => 23,
                'period' => 'month',
                'stripe_plan_id' => 'l4rb-plus',
                'features' => json_encode(array(
                    'Up to 20 Clients',
                    'Up to 8 Services',
                    'Email Notifications',
                    'Embeddable Widget',
                    'Phone Support'
                ))
            ),
            array(
                'name' => 'Plus',
                'price' => 35,
                'period' => 'month',
                'stripe_plan_id' => 'l4rb-pro',
                'features' => json_encode(array(
                    'Up to 40 Clients',
                    'Up to 20 Services',
                    'Email Notifications',
                    'Embeddable Widget',
                    'Phone Support'
                ))
            )
        );

        $currency = 'usd';
        $subscription_plans = DB::table('subscription_plans')->get();
        if(empty($subscription_plans)){
            //create subscription plans on stripe
            foreach($plans as $plan){

                $amount = $plan['price'] * 100; //stripe amount is expressed in cents

                Stripe_Plan::create(array(
                  "amount" => $amount,
                  "interval" => $plan['period'],
                  "name" => $plan['name'],
                  "currency" => $currency,
                  "id" => $plan['stripe_plan_id']
                  )
                );

            }
        }

        DB::table('subscription_plans')->truncate();
        DB::table('subscription_plans')->insert($plans);

    }

}