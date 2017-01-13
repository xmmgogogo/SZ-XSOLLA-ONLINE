<?php
//废弃页面............







//2015-4-13 修改统一调用当前版本的order表 mm
$vconfig = require_once('../vconfig.php');
$current_branch = $vconfig['current_branch'];
$platformId = $vconfig['platformId'];
$platformName = isset($vconfig['platformMap'][$platformId]) ? $vconfig['platformMap'][$platformId] : 'facebook';

//root目录
$basePath = '../' . $current_branch . '/j7/app/configs/' . $platformName;

require_once($basePath . '/configs.php');
$language = (isset($J7CONFIG['configs']['language']) && $J7CONFIG['configs']['language']) ? $J7CONFIG['configs']['language'] : 'en';

//引入正规的order表
require_once($basePath . '/orders/' . $language . '.php');

// var_dump($J7CONFIG['orders']);

return $J7CONFIG['orders'];die;