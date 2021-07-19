<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// Import the class namespaces first, before using it directly
use Srmklive\PayPal\Facades\PayPal;
use Srmklive\PayPal\Services\ExpressCheckout;
use Srmklive\PayPal\Services\AdaptivePayments;
// use Srmklive\PayPal\Services\AdaptivePayments;
use leifermendez\paypal\PaypalSubscription;
use Carbon\Carbon;

class PayPalPaymentController extends Controller
{
    //
    // private $provider = new ExpressCheckout;      // To use express checkout.
  private $app_id = "";
  private $app_sk = "";
  private $mode = "";
  

  private $product_id;
  private $plans = [];

  public function __construct() {
    $this->app_id = env('PAYPAL_APP_MODE') == 'test' ? env('PAYPAL_TEST_APP_ID') : env('PAYPAL_APP_ID');
    $this->app_sk = env('PAYPAL_APP_MODE') == 'test' ? env('PAYPAL_TEST_APP_SK') : env('PAYPAL_APP_SK');
    $this->mode = env('PAYPAL_APP_MODE');
    $pp = new PaypalSubscription($this->app_id, $this->app_sk, $this->mode);
    $products = $pp->getProduct();
    if (count($products) > 1) $this->createProduct();
    else $this->product_id = $products[count($products) - 1]['id'];
    $this->createPlans();
    // $this->createProduct();
    // $this->createPlans();
    // $this->getPlans();
  }

  public function createProduct() {
    $pp = new PaypalSubscription($this->app_id, $this->app_sk, $this->mode);
    $product = [
        'name' => 'Family365',
        'description' => 'Family trees',
        'type' => 'SERVICE',
        'category' => 'SOFTWARE',
    ];
    $res = $pp->createProduct($product);
    $this->product_id = $res['id'];

  }

  public function createPlans() {
    $pp = new PaypalSubscription($this->app_id, $this->app_sk, $this->mode);
    $plans = [
          [
            'name' => 'UTY',
            'description' => 'Unlimited trees yearly',
            'status' => 'ACTIVE',
            'billing_cycles' => [
                [
                    'frequency' => [
                        'interval_unit' => 'YEAR',
                        'interval_count' => '1'
                    ],
                    'tenure_type' => 'REGULAR',
                    'sequence' => '1',
                    'total_cycles' => '12',
                    'pricing_scheme' => [
                        'fixed_price' => [
                            'value' => '75',
                            'currency_code' => 'GBP'
                        ]
                    ]
                ]
            ],
            'payment_preferences' => [
                'auto_bill_outstanding' => 'true',
                'setup_fee' => [
                    'value' => '0',
                    'currency_code' => 'GBP'
                ],
                'setup_fee_failure_action' => 'CONTINUE',
                'payment_failure_threshold' => '3'
            ],
            'taxes' => [
                'percentage' => '10',
                'inclusive' => false
            ]
        ],

        [
            'name' => 'UTM',
            'description' => 'Unlimited trees monthly',
            'status' => 'ACTIVE',
            'billing_cycles' => [
                [
                    'frequency' => [
                        'interval_unit' => 'MONTH',
                        'interval_count' => '1'
                    ],
                    'tenure_type' => 'REGULAR',
                    'sequence' => '1',
                    'total_cycles' => '12',
                    'pricing_scheme' => [
                        'fixed_price' => [
                            'value' => '7.5',
                            'currency_code' => 'GBP'
                        ]
                    ]
                ]
            ],
            'payment_preferences' => [
                'auto_bill_outstanding' => 'true',
                'setup_fee' => [
                    'value' => '0',
                    'currency_code' => 'GBP'
                ],
                'setup_fee_failure_action' => 'CONTINUE',
                'payment_failure_threshold' => '3'
            ],
            'taxes' => [
                'percentage' => '10',
                'inclusive' => false
            ]
        ],

        [
            'name' => 'TTY',
            'description' => 'Ten trees yearly',
            'status' => 'ACTIVE',
            'billing_cycles' => [
                [
                    'frequency' => [
                        'interval_unit' => 'YEAR',
                        'interval_count' => '1'
                    ],
                    'tenure_type' => 'REGULAR',
                    'sequence' => '1',
                    'total_cycles' => '12',
                    'pricing_scheme' => [
                        'fixed_price' => [
                            'value' => '25',
                            'currency_code' => 'GBP'
                        ]
                    ]
                ]
            ],
            'payment_preferences' => [
                'auto_bill_outstanding' => 'true',
                'setup_fee' => [
                    'value' => '0',
                    'currency_code' => 'GBP'
                ],
                'setup_fee_failure_action' => 'CONTINUE',
                'payment_failure_threshold' => '3'
            ],
            'taxes' => [
                'percentage' => '10',
                'inclusive' => false
            ]
        ],

        [
            'name' => 'TTM',
            'description' => 'Ten trees monthly',
            'status' => 'ACTIVE',
            'billing_cycles' => [
                [
                    'frequency' => [
                        'interval_unit' => 'MONTH',
                        'interval_count' => '1'
                    ],
                    'tenure_type' => 'REGULAR',
                    'sequence' => '1',
                    'total_cycles' => '12',
                    'pricing_scheme' => [
                        'fixed_price' => [
                            'value' => '2.5',
                            'currency_code' => 'GBP'
                        ]
                    ]
                ]
            ],
            'payment_preferences' => [
                'auto_bill_outstanding' => 'true',
                'setup_fee' => [
                    'value' => '0',
                    'currency_code' => 'GBP'
                ],
                'setup_fee_failure_action' => 'CONTINUE',
                'payment_failure_threshold' => '3'
            ],
            'taxes' => [
                'percentage' => '10',
                'inclusive' => false
            ]
        ],

        [
            'name' => 'OTY',
            'description' => 'One tree yearly',
            'status' => 'ACTIVE',
            'billing_cycles' => [
                [
                    'frequency' => [
                        'interval_unit' => 'YEAR',
                        'interval_count' => '1'
                    ],
                    'tenure_type' => 'REGULAR',
                    'sequence' => '1',
                    'total_cycles' => '12',
                    'pricing_scheme' => [
                        'fixed_price' => [
                            'value' => '10',
                            'currency_code' => 'GBP'
                        ]
                    ]
                ]
            ],
            'payment_preferences' => [
                'auto_bill_outstanding' => 'true',
                'setup_fee' => [
                    'value' => '0',
                    'currency_code' => 'GBP'
                ],
                'setup_fee_failure_action' => 'CONTINUE',
                'payment_failure_threshold' => '3'
            ],
            'taxes' => [
                'percentage' => '10',
                'inclusive' => false
            ]
        ],

        [
            'name' => 'OTM',
            'description' => 'One tree monthly 1',
            'status' => 'ACTIVE',
            'billing_cycles' => [
                [
                    'frequency' => [
                        'interval_unit' => 'MONTH',
                        'interval_count' => '1'
                    ],
                    'tenure_type' => 'REGULAR',
                    'sequence' => '1',
                    'total_cycles' => '12',
                    'pricing_scheme' => [
                        'fixed_price' => [
                            'value' => '1',
                            'currency_code' => 'GBP'
                        ]
                    ]
                ]
            ],
            'payment_preferences' => [
                'auto_bill_outstanding' => 'true',
                'setup_fee' => [
                    'value' => '0',
                    'currency_code' => 'GBP'
                ],
                'setup_fee_failure_action' => 'CONTINUE',
                'payment_failure_threshold' => '3'
            ],
            'taxes' => [
                'percentage' => '10',
                'inclusive' => false
            ]
        ],
    ];
      
      
      $product = [
          'product_id' => $this->product_id //<--------***** ID DEL PRODUCTO
      ];

      $plans1 = $pp->getPlans();
      // $plans = $plans['plans'];
      // // dd($plans);
      if (count($plans1['plans']) < 7) {
        for ($i=0; $i < count($plans); $i++) { 
          $response = $pp->createPlan($plans[$i], $product);
          // var_dump($response);
          array_push($this->plans, $response);
          DB::table('landlord.plans')
            ->insert([
              'id' => $response['id'],
              'name' => $response['name'],
              'status' => $response['status'],
              'description' => $response['description'],
              'usage_type' => $response['usage_type'],
              'create_time' => $response['create_time'],
            ]);
        }

      } else {
        $plans = DB::table('landlord.plans')
          ->orderBy('name', 'desc')
          ->get();
        for ($i=0; $i < count($plans); $i++) {
          $plan = [
            "id" => $plans[$i]->id,
            "name" => $plans[$i]->name,
            "status" => $plans[$i]->status,
            "description" => $plans[$i]->description,
            "usage_type" => $plans[$i]->usage_type,
            "create_time" => $plans[$i]->create_time,
          ];
          array_push($this->plans, $plan);
        }
        // dd($this->plans);
      }
        

  }

  public function getTest() {
    $pp = new PaypalSubscription($this->app_id, $this->app_sk, $this->mode);
    $plans = $pp->getPlans();

    dd($pp->getSubscription("I-HLK6NP44YJBT"));
  }

  public function getPlans(Request $request) {
    $pp = new PaypalSubscription($this->app_id, $this->app_sk, $this->mode);
    $user = DB::table('landlord.users')
            ->where('email', $request->input('email'))
            ->get();


    if ($user[0]->paypal_subscription_id) {
      $subscription = $pp->getSubscription($user[0]->paypal_subscription_id);
      $sub = DB::table('landlord.paypal_subscriptions')
            ->where('id', $user[0]->paypal_subscription_id)
            ->get();
      if (count($sub) == 0) {
        DB::table('landlord.paypal_subscriptions')
              ->insert([
                'id' => $user[0]->paypal_subscription_id,
                'user_email' => $request->input('email'),
                'paypal_plan_id' => $subscription['plan_id'],
                'status' => $subscription['status'],
                'created_at' => $subscription['start_time'],
              ]);
      }
    } else {
      $subscription = false;
    }

    $result = array();
        foreach ($this->plans as $plan) {
            // $row = (array) $plan;
            $row ['id'] = $plan['id'];
            $row['nickname'] = $plan['name'];
            switch ($plan['name']) {
                case 'UTY':
                    $row['title'] = 'Unlimited trees yearly.';
                    $row['amount'] = '75';
                    $row['subscribed'] = ($subscription && $plan['id'] == $subscription['plan_id'] && $subscription['status'] == "ACTIVE") ? true : false;
                break;
                case 'UTM':
                    $row['title'] = 'Unlimited trees monthly.';
                    $row['amount'] = '7.5';
                    $row['subscribed'] = ($subscription && $plan['id'] == $subscription['plan_id'] && $subscription['status'] == "ACTIVE") ? true : false;
                break;
                case 'TTY':
                    $row['title'] = 'Ten trees yearly.';
                    $row['amount'] = '25';
                    $row['subscribed'] = ($subscription && $plan['id'] == $subscription['plan_id'] && $subscription['status'] == "ACTIVE") ? true : false;
                break;
                case 'TTM':
                    $row['title'] = 'Ten trees monthly.';
                    $row['amount'] = '2.5';
                    $row['subscribed'] = ($subscription && $plan['id'] == $subscription['plan_id'] && $subscription['status'] == "ACTIVE") ? true : false;
                break;
                case 'OTY':
                    $row['title'] = 'One tree yearly.';
                    $row['amount'] = '10';
                    $row['subscribed'] = ($subscription && $plan['id'] == $subscription['plan_id'] && $subscription['status'] == "ACTIVE") ? true : false;
                break;
                case 'OTM':
                    $row['title'] = 'One tree monthly.';
                    $row['amount'] = '1';
                    $row['subscribed'] = ($subscription && $plan['id'] == $subscription['plan_id'] && $subscription['status'] == "ACTIVE") ? true : false;
                break;
            }

            $result[] = $row;
        }
      return $result;
  }

  /* ** 
    Implementation Paypal Subscription.
  ** */
	public function handlePayment(Request $request)
  {
      
      // return $request;

        $pp = new PaypalSubscription($this->app_id, $this->app_sk, $this->mode);
          
        $startdate = Carbon::now();
        $startdate->addMinutes(1);

        $subscription = [
          'start_time' =>  $startdate->toAtomString(),
          'quantity' => '1',
          'shipping_amount' => [
              'currency_code' => 'GBP',
              'value' => '0'
          ],
          'subscriber' => [
              'name' => [
                  'given_name' => $request->input('first_name'),
                  'surname' => $request->input('last_name')
              ],
              'email_address' => $request->input('email'),
              'shipping_address' => [
                  'name' => [
                      'full_name' => $request->input('first_name').$request->input('last_name')
                  ],
                  'address' => [
                      'address_line_1' => '2211 N First Street',
                      'address_line_2' => 'Building  17',
                      'admin_area_2' => 'San Jose',
                      'admin_area_1' => 'CA',
                      'postal_code' => '95131',
                      'country_code' => 'US'
                  ]
              ]
          ],
          'application_context' => [
              'brand_name' => 'Racks',
              'locale' => 'es-ES',
              'shipping_preference' => 'SET_PROVIDED_ADDRESS',
              'user_action' => 'SUBSCRIBE_NOW',
              'payment_method' => [
                  'payer_selected' => 'PAYPAL',
                  'payee_preferred' => 'IMMEDIATE_PAYMENT_REQUIRED',
              ],
              'return_url' => 'http://127.0.0.1:3000/success',
              'cancel_url' => 'http://127.0.0.1:3000/cancel'
      
          ]
      ];

      // 'return_url' => 'https://github.com/leifermendez?status=returnSuccess',
      // 'cancel_url' => 'https://github.com/leifermendez?status=cancelUrl'
      
      $plan = [
          'plan_id' => $request->input('id') // <-------- ************ ID DEL PLAN CREADO
      ];

      $response = $pp->createSubscription($subscription, $plan);

      // *** Store paypal_subscription_id to USER db
      $user = DB::table('landlord.users')
                ->where('email', $request->input('email'))
                ->get();

      // if ($user['paypal_subscription_id']) {
      $response1 = $pp->cancelSubscription($user[0]->paypal_subscription_id);
      // }

      DB::table('landlord.users')
        ->where('email', $request->input('email'))
        ->update(['paypal_subscription_id' => $response['id']]);

      $updated_at = Carbon::now();
      DB::table('landlord.paypal_subscriptions')
        ->where('id', $user[0]->paypal_subscription_id)
        ->update(['status' => "CANCELLED", 'updated_at' => $updated_at->toAtomString()]);



      return $response['links'][0]['href'];
      // return $response;

      // $res = $pp->getSubscription($response['id']);

      // dd($res);

  }

  /* ** 
    Cancel Paypal Subscription.
  ** */
  public function unsubscribePaypal(Request $request) {
    $pp = new PaypalSubscription($this->app_id, $this->app_sk, $this->mode);
    $user = DB::table('landlord.users')
            ->where('email', $request->input('email'))
            ->get();
    $response1 = $pp->cancelSubscription($user[0]->paypal_subscription_id);
    DB::table('landlord.users')
        ->where('email', $request->input('email'))
        ->update(['paypal_subscription_id' => ""]);

    $updated_at = Carbon::now();
    DB::table('landlord.paypal_subscriptions')
        ->where('id', $user[0]->paypal_subscription_id)
        ->update(['status' => "CANCELLED", 'updated_at' => $updated_at->toAtomString()]);
    return $response1;      
  }

  public function paymentCancel()
  {
      // return redirect("/");
      dd('Your payment has been declend. The payment cancelation page goes here!');
  }

  public function paymentSuccess(Request $request)
  {
      if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {

          dd('Payment was successfull. The payment success page goes here!');
          // return redirect("http://localhost:3000/subscription");
      }

      dd('Error occured!');
  }

}
