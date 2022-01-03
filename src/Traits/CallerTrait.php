<?php

namespace Weishaypt\LavaRu\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Weishaypt\LavaRu\Exceptions\InvalidPaidOrder;
use Weishaypt\LavaRu\Exceptions\InvalidSearchOrder;

trait CallerTrait
{
    /**
     * @param Request $request
     * @return mixed
     *
     * @throws InvalidSearchOrder
     */
    public function callSearchOrder(Request $request)
    {
        if (is_null(config('lavaru.searchOrder'))) {
            throw new InvalidSearchOrder();
        }

        return App::call(config('lavaru.searchOrder'), ['order_id' => $request->input('order_id')]);
    }

    /**
     * @param Request $request
     * @param $order
     * @return mixed
     * @throws InvalidPaidOrder
     */
    public function callPaidOrder(Request $request, $order)
    {
        if (is_null(config('lavaru.paidOrder'))) {
            throw new InvalidPaidOrder();
        }

        return App::call(config('lavaru.paidOrder'), ['order' => $order]);
    }
}
