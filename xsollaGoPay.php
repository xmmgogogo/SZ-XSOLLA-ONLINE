<?php
$return_token = array();

//ajax请求，购买道具基础属性
if(isset($_REQUEST['uId']) && isset($_REQUEST['configId'])) {
    include_once "config.php";
    $uId            = intval($_REQUEST['uId']);
    $configId       = intval($_REQUEST['configId']);
    $current        = trim($_REQUEST['current']);
    $extraMsg       = trim($_REQUEST['extraMsg']);
    $amount         = floatval($_REQUEST['payAmount']);
    $language        = "en";
    $buyNum         = 0;

    if(isset($orderConfig[$configId])) {
        //name
        $description    = sprintf($orderConfig[$configId]['name'], $amount, $current);

        $post_data = array(
            "settings" => array(
                "mode"          => $sandBox,
                "project_id"    => $projectId,
                "language"      => $language,
                "currency"      => $current,//"USD",
                "return_url"    => sprintf($return_url, $uId, $configId, $buyNum),
            ),
            "user" => array(
                "id" => array(
                    "value"     => $uId,
                    "hidden"    => true,
                )
            ),
            "purchase" => array(
                "checkout" => array(
                    "currency"  => $current,//"USD",
                    "amount"    => $amount,
                ),
                "description" => array(
                    "value"     => $description
                )
            ),

            //这里别问为什么，我也搞不懂这秘密，反正只能写itemId，其他你不管填什么都不行，妖怪！！！
            "custom_parameters" => [
                'itemId' => $extraMsg
            ],
//            "custom_parameters" => [
//                'extra' => 123456
//            ],
//            "custom_parameters" => array(
//                "itemId"  => $configId,
//                "buyNum"  => $buyNum,
//            ),
        );

        $return_token = sendByCurl($url_post, $xsollaId . ':' . $xsollaSecret, json_encode($post_data), true);
    }
}

//var_dump($return_token);
//FOR ADD
//if(isset($return_token['token']) && $return_token['token']){
//    echo sprintf($iframe_url, $return_token['token']);die;
//} else {
//    echo '';die;
//}
?>

<!DOCTYPE html>
<html>
<head>
    <title>xsolla payment</title>
</head>
<script id="xsolla-paystation-lightbox" type="text/javascript" src="https://secure.xsolla.com/partners/embed/lightbox.js"></script>
<script type="text/javascript">
//    window.onload = function() {
//        document.getElementById("paystation-link").click()
//    }
</script>
<body>
<?php
if(isset($return_token['token']) && $return_token['token']) :
?>
<iframe id="paystation" src="<?php echo sprintf($iframe_url, $return_token['token'])?>" width="730px" height="730px" style="border:0"></iframe>
<!--<a id="paystation-link" href="#" onclick="XPSLightBox.open('<?php echo sprintf($iframe_url, $return_token['token'])?>', 900, 650); return false;"></a>-->
<?php
else:
    echo "Parameter error";
endif;
?>
</body>
</html>