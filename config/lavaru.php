<?php

return [

    /*
     * Wallet`s id
     */
    'wallet_id' => env('LAVARU_WALLET_ID', ''),

    /*
     * JWT-token for Authorization
     */
    'api_token' => env('LAVARU_API_TOKEN', ''),

    /*
     * Who to write off the commission from
     * 1 - Write off from the client
     * 0 - Write out from the store
     */
    'subtract' => env('LAVARU_SUBTRACT', 0),

    /*
     *  SearchOrder
     *  Search order in the database and return order details
     *  Must return array with:
     *
     *  _orderStatus
     *  _orderSum
     */
    'searchOrder' => null, //  'App\Http\Controllers\LavaRuController@searchOrder',

    /*
     *  PaidOrder
     *  If current _orderStatus from DB != paid then call PaidOrderFilter
     *  update order into DB & other actions
     */
    'paidOrder' => null, //  'App\Http\Controllers\LavaRuController@paidOrder',

    /*
     * Customize error messages
     */
    'errors' => [
        'validateOrderFromHandle' => 'Validate Order Error',
        'searchOrder' => 'Search Order Error',
        'paidOrder' => 'Paid Order Error',
    ],

    /*
     * Redirect URL after unsuccessful payment
     */
    'hook_url' => null,

    /*
     * URL where to redirect the user after successful payment.
     * (If empty, the value is taken from the store settings.
     *  This parameter is in priority for redirection)
     */
    'success_url' => null,
    /*
     * URL where to redirect the user after error payment.
     * (If empty, the value is taken from the store settings.
     *  This parameter is in priority for redirection)
     */
    'fail_url' => null,
];
