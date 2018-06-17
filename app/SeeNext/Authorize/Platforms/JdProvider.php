<?php

namespace App\SeeNext\Authorize\Platforms;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;

/**
 * Created by PhpStorm.
 * User: lvdingtao
 * Date: 2018/5/14
 * Time: 下午10:52
 */
class JdProvider
{
    /*
     * 基础URL
     * @var string
     * */

    protected $baseUrl = 'https://oauth.jd.com/oauth';

    protected $clientId;

    protected $redirectUrl;

    protected $callback;

    public function __construct($config = [])
    {
        $this->clientId = 'CEE831DD61363C34C5C1BA1E0A3D6BF6';
        $this->clientSecret = '6d8a2e4576fb4fafaa1c5d7ab3064560';
        $this->callback = route('callback', ['platform' => 'jd']);
        $this->redirectUrl = $this->buildAuthUrlFromBase($this->baseUrl, null);

    }

    protected function buildAuthUrlFromBase($url, $state)
    {
        $query = http_build_query($this->getCodeFields($state), '', '&');
        return $url.'/authorize'.'?'.$query.'#wechat_redirect';
    }

    protected function getCodeFields($state = null)
    {
        return [
            'client_id'     => $this->clientId,
            'redirect_uri'  => $this->callback,
            'response_type' => 'code',
            'scope'         => 'read',
            'state'         => $state ?: md5(time()),
            'view'          => ''
        ];
    }
    protected function getTokenFields($request)
    {
        return array_filter([
            'grant_type' => 'authorization_code',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'code' => $request->input('code'),
            'state' => $request->input('state'),
            'redirect_uri'  => $this->callback,
        ]);
    }

    protected function getTokenUrl()
    {
        return $this->baseUrl. '/token';
    }

    public function getAccessToken($request)
    {
        $http = new Client();

        $response = $http->post($this->getTokenUrl(), [
            'headers'=> [
//                'Accept-Charset'    => 'utf-8',
                'Accept'            => 'application/json'
            ],
            'query' => $this->getTokenFields($request),
        ]);
        return $this->parseAccessToken($response->getBody());
    }

    public function parseAccessToken($body)
    {
        return $body->getContents();
    }

    public function redirect() {

        return redirect($this->redirectUrl);

    }
}