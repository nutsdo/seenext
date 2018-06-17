<?php
namespace App\Repositories\Jd;
/**
 * Created by PhpStorm.
 * User: lvdingtao
 * Date: 2018/5/16
 * Time: 上午12:40
 */
class JdRepository
{
    const SERVER_URL = 'https://api.jd.com/routerjson';

    protected $appKey;

    protected $appSecret;

    protected $accessToken;

    protected $params = [];

    protected $client = null;

    public function __construct($options = [])
    {
        $this->params = $options;

        $jdConfig = config('jd');

        $this->appKey = $jdConfig['appKey'];
        $this->appSecret = $jdConfig['appSecret'];
        $this->accessToken = $this->params['accessToken'];

        $this->setClient();
    }

    protected function setClient()
    {
        $this->client = new \JdClient();

        $this->client->appKey       = $this->appKey;

        $this->client->appSecret    = $this->appSecret;

        $this->client->accessToken  = $this->accessToken;

        $this->client->serverUrl    = self::SERVER_URL;

        $this->client->format       = 'json';

        return $this->client;
    }

    public function getJdGoodsCategories()
    {
        $req = new \UnionSearchGoodsCategoryQueryRequest();

        $parentId = isset($this->params['parentId']) ? $this->params['parentId'] : 0;

        $grade = isset($this->params['grade']) ? $this->params['grade'] : 0;

        $req->setParentId( $parentId );

        $req->setGrade( $grade );

        $resp = $this->client->execute($req, $this->client->accessToken);

        return $resp;
    }

    public function queryCouponGoods($options = [])
    {
        $req = new \UnionSearchQueryCouponGoodsRequest();

//        $req->setSkuIdList( "123,234,345" );
        $req->setPageIndex( 123 );
        $req->setPageSize( 123 );
        $req->setCid3( 123 );
//        $req->setGoodsKeyword( "jingdong" );
//        $req->setPriceFrom( 123 );
//        $req->setPriceTo( 123 );

        $resp = $this->client->execute($req, $this->client->accessToken);
        return $resp;
    }

    public function querySecKillGoods()
    {
        $req = new \ServiceGoodsQuerySecKillGoodsRequest();

        $req->setSkuIdList( "123,234,345" );

        $req->setPageIndex( 123 );

        $req->setPageSize( 123 );

        $req->setIsBeginSecKill( 123 );

        $req->setSecKillPriceFrom( 123 );

        $req->setSecKillPriceTo( 123 );

        $req->setCid1Id( 123 );

        $req->setCid2Id( 123 );

        $req->setCid3Id( 123 );

        $req->setOwner( "jingdong" );

        $req->setCommissionShareFrom( 123 );

        $req->setCommissionShareTo( 123 );

        $req->setSortName( "jingdong" );

        $req->setSort( "jingdong" );

        $resp = $this->client->execute($req, $this->client->accessToken);

        return $resp;
    }
}