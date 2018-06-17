<?php

namespace App\Http\Controllers;

use App\SeeNext\Authorize\Platforms\JdProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AuthorizationController extends Controller
{
    //

    public function auth(Request $request, $platform){

        $function = $platform.'Authorize';

        return $this->$function($request);

    }

    private function jdAuthorize($request)
    {
        $jd = new JdProvider();

        return $jd->redirect();
    }

    public function callback(Request $request, $platform){

        $function = $platform.'Callback';

        return $this->$function($request);
    }

    private function jdCallback($request)
    {
        if($request->input('code')) {
            $jd = new JdProvider();
            $accessToken = $jd->getAccessToken($request);

            $accessToken = iconv('gbk', 'utf8', $accessToken);

            $accessToken = str_replace("\n", '', $accessToken);

            $accessToken = \GuzzleHttp\json_decode($accessToken);

            if (Cache::has('jd_authorization_info')) {

                Cache::forever('jd_authorization_info', $accessToken);
            }

            return redirect()->route('jd.getCategories');
        }
    }
}
