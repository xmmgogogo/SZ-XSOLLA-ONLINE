<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Xsolla\SDK\Project;
use Xsolla\SDK\User;
use Xsolla\SDK\Invoice;
use Xsolla\SDK\PaymentPage\UrlBuilderFactory;

//项目配置
$paymentUrl     = 'https://sandbox-secure.xsolla.com/paystation2/?';
$projectId      = '14582';//后台创建的项目ID
$projectSecret  = 'rW7cl4gPZwc2ntBJ';//后台创建的项目密钥

//ajax请求，购买道具基础属性
$uId            = 100005038140608;
$configId       = 300013;
$description    = '10diamonds';
$amount         = rand(1,50);

//组合
$project            = new Project($projectId, $projectSecret);
$user               = new User($uId, $configId);
$invoice            = new Invoice;
$urlBuilderFactory  = new UrlBuilderFactory($project);

$invoice->setId($configId);
$invoice->setVirtualCurrencyAmount($amount);

//生成跳转链接
$url = $urlBuilderFactory->getCreditCards()
    ->setInvoice($invoice)
     ->setUser($user)
//     ->unlockParameterForUser('email')
//    ->setCountry('US')
//    ->setLocale('en')
//    ->setParameter('description', $description)
    ->getUrl($paymentUrl);

echo $url;die;
