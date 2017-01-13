<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Xsolla\SDK\Project;
use Xsolla\SDK\User;
use Xsolla\SDK\Invoice;
use Xsolla\SDK\PaymentPage\UrlBuilderFactory;

$user = new User('username');
$user->setV1('100005038140608')
    ->setV2('300013');

$demoProject = new Project(
    '4783',//demo project id
    'key'//demo project secret key
);

$invoice = new Invoice;
$invoice->setVirtualCurrencyAmount(10);

$urlBuilderFactory = new UrlBuilderFactory($demoProject);

$url = $urlBuilderFactory->getCreditCards()
//    ->setInvoice($invoice)
//    ->setUser($user)
//    ->unlockParameterForUser('email')
//    ->setCountry('US')
//    ->setLocale('en')
//    ->setParameter('description', 'Purchase description')
    ->getUrl();

echo 'URL to PayStation payment page: ' . $url . PHP_EOL;
