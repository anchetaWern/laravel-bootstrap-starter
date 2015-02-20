<?php

class HomeController extends BaseController {

	protected $layout = 'layouts.default';

	public function index(){

        $subscription_plans = SubscriptionPlan::get();

        $page_data = array(
            'subscription_plans' => $subscription_plans
        );

		$this->layout->title = 'Home';
		$this->layout->content = View::make('index', $page_data);

	}

	public function register(){

        $plan_id = Session::get('plan.id');
        $plan = SubscriptionPlan::find($plan_id);

        $after_15_years = date('Y') + 15;
        $years = range(date('Y'), $after_15_years);

        $month_ids = range(1, 12);
        $months = array();
        foreach($month_ids as $month_id){
            $months[$month_id] = date('F', strtotime('2012-' . $month_id . '-01'));
        }

        $page_data = array(
            'plan' => $plan,
            'months' => $months,
            'years' => $years
        );

		$this->layout->title = 'Sign Up';
        $this->layout->signup = true;
        $this->layout->handlebars = true;
        $this->layout->stripe = true;
		$this->layout->content = View::make('register', $page_data);

	}


	public function doRegister(){

        $rules = array(
            'username' => 'required',
            'email' => 'email|required|unique:users',
            'stripeToken' => 'required',
            'card_number' => 'required',
            'security_code' => 'required'
        );

        if(!Session::has('google')){
            $rules['password'] = 'min:8|required';
        }

        $validator = Validator::make(Input::all(), $rules);

        if($validator->fails()){
            return Redirect::to('/register')
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        }else{

            $username = Input::get('username');
            $email = Input::get('email');
            $password = Input::get('password');
            $token = Input::get('stripeToken');


            $customer = Stripe_Customer::create(
                array(
                  "email" => $email,
                  "description" => "Customer for " . Config::get('app.title') . " - " . $username,
                  "card" => $token
                )
            );

            $stripe_customer_id = $customer->id;

            if(Session::has('plan.id')){

                $plan_id = Session::get('plan.id');

                $plan = SubscriptionPlan::find($plan_id);

                //assign customer to subscription plan
                //assigning to a subscription plan immediately makes a charge to the customer
                try{
                    $subscription = $customer->subscriptions->create(array('plan' => $plan->stripe_plan_id));
                }catch(Stripe_CardError $e){
                    $error_body = $e->getJsonBody();
                    $err  = $error_body['error'];

                    return Redirect::back()->with('message', array('type' => 'danger', 'text' => $err['message']))
                      ->withInput(Input::except('password'));

                }catch(Stripe_ApiConnectionError $e){

                    return Redirect::back()
                      ->with('message', array('type' => 'danger', 'text' => 'Network communication with Stripe failed, please try again'))
                      ->withInput(Input::except('password'));

                }catch(Stripe_Error $e){

                    return Redirect::back()
                      ->with('message', array('type' => 'danger', 'text' => 'An error with Stripe occured, please try again'))
                      ->withInput(Input::except('password'));

                }catch(Exception $e){

                    return Redirect::back()
                      ->with('message', array('type' => 'danger', 'text' => 'Something went wrong, please try again'))
                      ->withInput(Input::except('password'));

                }

                $stripe_subscription_id = $subscription->id;

                $user = new User;
                $user->username = $username;
                $user->email = $email;
                $user->password = Hash::make($password);
                $user->subscription_planid = $plan->id;
                $user->stripe_customer_id = $stripe_customer_id;
                $user->stripe_subscription_id = $stripe_subscription_id;
                $user->save();

                Session::forget('plan.id');

                Auth::loginUsingId($user->id);

            }

            return Redirect::to('/admin');
        }

	}

	public function login(){

		$this->layout->title = 'Login';
		$this->layout->content = View::make('login');

	}

	public function doLogin(){

        $rules = array(
            'email' => 'email|required',
            'password' => 'required'
        );

        $validator = Validator::make(Input::all(), $rules);
        if($validator->fails()){

            return Redirect::to('/login')
                ->withErrors($validator)
                ->withInput(Input::except('password'));

        }else{

            $user_data = array(
                'email' => Input::get('email'),
                'password' => Input::get('password')
            );

            if(Auth::attempt($user_data)){
               return Redirect::to('/admin');
            }else{
                return Redirect::to('/login')
                    ->with('message', array('type' => 'danger', 'text' => 'Incorrect email or password'));
            }

        }

	}


    public function registerCheck(){

        $username = Input::get('username');
        $email = Input::get('email');
        $password = Input::get('password');

        $rules = array(
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8'
        );

        $validator = Validator::make(Input::all(), $rules);

        $errors = null;
        if($validator->fails()){
            $errors = array();
            $messages = $validator->messages();
            foreach($messages->all() as $mess){
                $errors[] = $mess;
            }

            return array(
                'errors' => $errors
            );
        }

        return 'success';
    }


    public function selectPlan($id){
        Session::put('plan.id', $id);
        return Redirect::to('/register');
    }

}
