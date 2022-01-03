<?php

namespace Weishaypt\LavaRu\Traits;

use Illuminate\Http\Request;
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


        return true;
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
