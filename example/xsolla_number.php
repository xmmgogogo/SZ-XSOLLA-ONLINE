<?php
require_once __DIR__.'/../vendor/autoload.php';

use Xsolla\SDK\Api\ApiFactory;
use Xsolla\SDK\Project;
use Xsolla\SDK\User;

$user = new User('demo_user');

$demoProject = new Project(
    '14582',//demo project id
    'rW7cl4gPZwc2ntBJ'//demo project secret key
);

$apiFactory = new ApiFactory($demoProject);
$numberApi = $apiFactory->getNumberApi();

$number = $numberApi->getNumber($user);

echo 'Xsolla number for user "demo_user": '. $number . PHP_EOL;
