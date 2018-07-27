<?
global $APPLICATION;

function getShareCount($id,$url){
  $uri = $url;
  $uri = explode("?",$uri);
  $uri = urlencode($uri);
  $vkUrl = "https://vk.com/share.php?act=count&index=1&url=https://st-mall.ru".$uri[0];


$curl = curl_init();
curl_setopt($curl,CURLOPT_URL,$vkUrl);
curl_setopt($curl,CURLOPT_FAILONERROR,1);
curl_setopt($curl,CURLOPT_TIMEOUT,10);
curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0); // не проверять SSL сертификат
curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0); // не проверять Host SSL сертификата
@curl_setopt($curl,CURLOPT_FOLLOWLOCATION,1);
curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
$resultVK = curl_exec($curl);
curl_close($curl);


  $resultVK = str_replace("VK.Share.count(","",$resultVK);
  $resultVK = str_replace("1, ","",$resultVK);
  $resultVK = str_replace(");","",$resultVK);

return $resultVK;

}
?>
