<?php

namespace Weishaypt\LavaRu\Traits;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

trait ValidateTrait
{
    /**
     * @param Request $request
     * @return bool
     */
    public function validate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'invoice_id' => 'required',
            'order_id' => 'required',
            'status' => 'required',
            'pay_time' => 'required',
            'amount' => 'required',
            'custom_fields' => 'required',
        ]);

        if ($validator->fails()) {
            return false;
        }

        return true;
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function validateApi(Request $request)
    {
        /**
         * @var $client Client
         */
        $client = static::getClient();
        $response = $client->post('/invoice/info', [
            'form_params' => [
                'id' => $request->invoice_id,
                'order_id' => $request->order_id
            ]
        ]);

        $data = json_decode($response->getBody()->getContents());

        Log::info(json_encode($data));

        if(isset($data->invoice) && isset($data->invoice->status)) {
            if($data->invoice->status == 'success') return  true;
        }

        return false;
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function validateOrderFromHandle(Request $request)
    {
        return $this->validate($request)
                    && $this->validateApi($request);
    }
}
