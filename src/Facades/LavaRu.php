<?php

namespace Weishaypt\LavaRu\Facades;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string handle(Request $request)
 * @method static string getPayUrl($amount, $order_id, $desc = null, $custom_field = null)
 * @method static string redirectToPayUrl($amount, $order_id, $desc = null, $custom_field = null)
 * @method static string getFormSignature($project_id, $amount, $secret, $order_id)
 *
 * @see \Weishaypt\LavaRu\LavaRu
 */
class LavaRu extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'lavaru';
    }
}
