<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\SubscribeSuccessfully;
use App\Notifications\UnsubscribeSuccessfully;
use Stripe;

class StripeController extends Controller
{
    protected $plans;

    public function __construct()
    {
        Stripe\Stripe::setApiKey(\Config::get('services.stripe.secret'));
        $this->plans = Stripe\Plan::all();
    }

    public function getPlans()
    {
        foreach ($this->plans as $plan) {
            switch ($plan->nickname) {
                case 'UTY':
                    $plan->title = 'Unlimited trees yearly.';
                break;
                case 'UTM':
                    $plan->title = 'Unlimited trees monthly.';
                break;
                case 'TTY':
                    $plan->title = 'Ten trees yearly.';
                break;
                case 'TTM':
                    $plan->title = 'Ten trees monthly.';
                break;
                case 'OTY':
                    $plan->title = 'One tree yearly.';
                break;
                case 'OTM':
                    $plan->title = 'One tree monthly.';
                break;
            }
            $plan->subscribed = false;
        }

        return $this->plans;
    }

    public function getCurrentSubscription()
    {
        $user = auth()->user();
        $data = [];
        $data['has_payment_method'] = $user->hasDefaultPaymentMethod();
        if ($user->subscribed('default')) {
            $data['subscribed'] = true;
            $data['plan_id'] = $user->subscription()->stripe_plan;
        } else {
            $data['subscribed'] = false;
        }

        return $data;
    }

    public function getIntent()
    {
        $user = auth()->user();

        return ['intent' => $user->createSetupIntent()];
    }

    public function subscribe()
    {
        $user = auth()->user();
        $user->syncRoles('OTY');
        $plan_id = request()->plan_id;
        if (request()->has('payment_method')) {
            $paymentMethod = request()->payment_method;
            $user->newSubscription('default', $plan_id)->create($paymentMethod, ['name' => request()->card_holder_name, 'address' => ['country' => 'GB', 'state' => 'England', 'city' => 'Abberley', 'postal_code' => 'WR6', 'line1' => 'test', 'line2' => '']]);
            $user->notify(new SubscribeSuccessfully($plan_id));
        } elseif ($user->hasDefaultPaymentMethod()) {
            $paymentMethod = $user->defaultPaymentMethod();
            $user->newSubscription('default', $plan_id)->create($paymentMethod->id);
            $user->notify(new SubscribeSuccessfully($plan_id));
        } else {
            $user->subscription('default')->swap($plan_id);
        }

        return ['success' => true];
    }

    public function unsubscribe()
    {
        $user = auth()->user();
        $user->subscription('default')->cancel();
        // $user->role_id = 3; //expired role
        $user->save();
        $user->notify(new UnsubscribeSuccessfully($user->subscription()->stripe_plan));

        return ['success' => true];
    }

    public function webhook()
    {
        $data = request()->all();
        $user = User::where('stripe_id', $data['data']['object']['customer'])->first();
        if ($user) {
            $plan_nickname = $data['data']['object']['items']['data'][0]['plan']['nickname'];
            foreach ($this->plans as $plan) {
                if ($plan->nickname == $plan_nickname) {
                    switch ($plan->nickname) {
                        case 'UTY':
                            $user->syncRoles('UTY');
                        break;
                        case 'UTM':
                            $user->syncRoles('UTM');
                        break;
                        case 'TTY':
                            $user->syncRoles('TTY');
                        break;
                        case 'TTM':
                            $user->syncRoles('TTM');
                        break;
                        case 'OTY':
                            $user->syncRoles('OTY');
                        break;
                        case 'OTM':
                            $user->syncRoles('OTM');
                        break;
                    }
                }
            }
        } else {
            echo 'User not found!';
        }
    }
}
