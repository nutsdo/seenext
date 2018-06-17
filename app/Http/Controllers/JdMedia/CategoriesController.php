<?php

namespace App\Http\Controllers\JdMedia;

use App\Repositories\Jd\JdRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class CategoriesController extends Controller
{
    //

    public function getCategories(Request $request)
    {
        $token = Cache::get('jd_authorization_info');

        $options = [
            'appKey'      => 'CEE831DD61363C34C5C1BA1E0A3D6BF6',
            'appSecret'   => '6d8a2e4576fb4fafaa1c5d7ab3064560',
            'accessToken' => $token->access_token
        ];
        $jd = new JdRepository($options);
        $categories = $jd->getJdGoodsCategories();
//        $categories = stripslashes($categories);
//        $json = \GuzzleHttp\json_decode($categories);
        dd($categories);

    }
}
