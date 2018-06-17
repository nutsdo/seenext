<?php

namespace App\Http\Controllers\JdMedia;

use App\Repositories\Jd\JdRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class QueryCouponGoodsController extends Controller
{
    //
    public function QueryCouponGoods(Request $request)
    {

        $token = Cache::get('jd_authorization_info');

        $options = [
            'accessToken' => $token->access_token
        ];

        $jd = new JdRepository($options);

        $resp = $jd->queryCouponGoods();
        dd($resp);

    }

    public function querySecKillGoods(Request $request)
    {

    }
}
