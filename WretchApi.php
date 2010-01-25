<?php
/*Yahoo! Social SDK*/
require_once dirname(__FILE__).'/yosdk/lib/Yahoo.inc';
/*API所使用的KEYs設定*/
require_once dirname(__FILE__).'/inc/api_key.php';

$wa = new WretchAPI();
echo '科科';
echo '<XMP>';

$arr = $wa->siteDiguAnnounces();
$obj = json_decode($arr['responseBody']);
print_r($arr);
echo $obj->{'digu_today_messages'}->{'digu_today_messages'}[0]->{'userid'}."\n";


$arr = $wa->siteAlbumCategories();
$obj = json_decode($arr['responseBody']);
print_r($arr);
print_r($obj->{'site_album_categories'}->{'site_album_categories'});

$arr = $wa->siteVideoCategories();
$obj = json_decode($arr['responseBody']);
print_r($arr);
print_r($obj->{'site_video_categories'}->{'site_video_categories'});

$arr = $wa->getCover( 'origin', 'json');
$obj = json_decode($arr['responseBody']);
print_r($arr);
echo $obj->{'cover'}->{'url'}."\n";
echo $obj->{'cover'}->{'lang'}."\n";
echo $obj->{'cover'}->{'uri'}."\n";

$arr = $wa->transToWid( '', 'json');
$obj = json_decode($arr['responseBody']);
print_r($arr);
echo $obj->{'profile'}->{'wid'}."\n";
echo $obj->{'profile'}->{'lang'}."\n";
echo $obj->{'profile'}->{'uri'}."\n";

$arr = $wa->getProfile( '', 'json');
$obj = json_decode($arr['responseBody']);
print_r($arr);
echo $obj->{'profile'}->{'title'}."\n";
echo $obj->{'profile'}->{'desc'}."\n";
echo $obj->{'profile'}->{'nick'}."\n";
echo $obj->{'profile'}->{'birthday'}."\n";
echo $obj->{'profile'}->{'intro'}."\n";
echo $obj->{'profile'}->{'sex'}."\n";
echo $obj->{'profile'}->{'lang'}."\n";
echo $obj->{'profile'}->{'uri'}."\n";

class WretchAPI
{
    public $guid; # Globally Unique Identifier
    public $yss;  # YahooSession
 
    function __construct()
    {
        /*取得Yahoo Session*/
        $this->yss = YahooSession::requireSession( OAUTH_CONSUMER_KEY, OAUTH_CONSUMER_SECRET, OAUTH_APP_ID);
        /*取得登入者的GUID*/
        $this->guid = $this->yss->guid;
    }

#   取得相簿全站分類列表
    function siteAlbumCategories()
    {
        return $this->yss->client->get('http://wretch.yahooapis.com/v1/siteAlbumCategories');
    }

#   取得影音全站分類列表
    function siteVideoCategories()
    {
        return $this->yss->client->get('http://wretch.yahooapis.com/v1/siteVideoCategories');
    }

#   取得20則全站最新嘀固
    function siteDiguAnnounces()
    {
        return $this->yss->client->get('http://wretch.yahooapis.com/v1/siteDiguAnnounces');
    }

#   profileService/[guid]/cover/[cover_size]：取得 user 大頭貼 
#   cover_size : [60, 90, 200, origin] 
#   format : xml, json
    function getCover( $cover_size, $format )
    {
        $url = 'http://wretch.yahooapis.com/v1/profileService/'.$this->guid.'/cover/'.$cover_size;
        $param = array('format'=>$format);
        return $this->yss->client->get($url, $param);
    }

#   profileService/[guid]/idTransformation：轉換 user 的 GUID 為 WID(Wretch ID) 
    function transToWid( $guid, $format )
    {
        if($guid==null)
            $guid = $this->guid;
        $url = 'http://wretch.yahooapis.com/v1/profileService/'.$guid.'/idTransformation';
        $param = array('format'=>$format);
        return $this->yss->client->get($url, $param);
    }

#   profileService/[guid]：取得 user 個人資料 
    function getProfile( $guid, $format )
    {
        if($guid==null)
            $guid = $this->guid;
        $url =  'http://wretch.yahooapis.com/v1/profileService/'.$guid;
        $param = array('format'=>$format);
        return $this->yss->client->get($url, $param);
    }
}
?>
