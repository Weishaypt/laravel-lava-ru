<?php

namespace Weishaypt\LavaRu;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Weishaypt\LavaRu\Traits\CallerTrait;
use Weishaypt\LavaRu\Traits\ValidateTrait;

class LavaRu
{
    use ValidateTrait;
    use CallerTrait;

    //

    /**
     * EnotIo constructor.
     */
    public function __construct()
    {
        //
    }

    /**
     * @param $amount
     * @param $order_id
     * @param null $desc
     * @param null $custom_field
     * @return string
     */
    public function getPayUrl($amount, $order_id, $desc = null, $custom_field = null)
    {
        $client = new Client([
            'base_uri' => 'https://api.lava.ru'
        ]);
        $response = $client->post('/invoice/create', [
            'headers' => [
              'Authorization' => config('lavaru.api_token')
            ],
            'form_params' => [
                'wallet_to' => config('lavaru.wallet_id'),
                'sum' => $amount,
                'order_id' => $order_id,
                'subtract' => config('lavaru.subtract'),
                'custom_fields'  => $custom_field,
                'hook_url' => config('lavaru.hook_url'),
                'success_url' => config('lavaru.success_url'),
                'fail_url' => config('lavaru.fail_url'),
                'comment' => $desc
            ]
        ]);

        $data = json_decode($response->getBody()->getContents());

        Log::info(json_encode($data));

        if(isset($data->status) && $data->status == 'success') {
            return $data['url'];
        }
        return null;
    }

    /**
     * @param $amount
     * @param $order_id
     * @param null $desc
     * @param null $custom_field
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToPayUrl($amount, $order_id, $desc = null, $custom_field = null)
    {
        return redirect()->away($this->getPayUrl($amount, $order_id, $desc, $custom_field));
    }

    /**
     * @param Request $request
     * @return string
     * @throws Exceptions\InvalidPaidOrder
     * @throws Exceptions\InvalidSearchOrder
     */
    public function handle(Request $request)
    {
        // Validate request from FreeKassa
        if (! $this->validateOrderFromHandle($request)) {
            return $this->responseError('validateOrderFromHandle');
        }

        // Search and get order
        $order = $this->callSearchOrder($request);

        if (! $order) {
            return $this->responseError('searchOrder');
        }

        // If order already paid return success
        if (Str::lower($order['_orderStatus']) === 'paid') {
            return $this->responseYES();
        }

        // PaidOrder - update order info
        // if return false then return error
        if (! $this->callPaidOrder($request, $order)) {
            return $this->responseError('paidOrder');
        }

        // Order is paid and updated, return success
        return $this->responseYES();
    }

    /**
     * @param $error
     * @return string
     */
    public function responseError($error)
    {
        return config('enotio.errors.'.$error, $error);
    }

    /**
     * @return string
     */
    public function responseYES()
    {
        // Must return 'YES' if paid successful

        return 'YES';
    }
}
