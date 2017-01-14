<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/1/14
 * Time: 14:03
 */


/**
 * @param array $weight 权重 例如array('a'=>200,'b'=>300,'c'=>500)
 * @return string key 键名
 */
//function roll($weight = array()) {
//    $roll = rand ( 1, array_sum ( $weight ) );
//    $_tmpW = 0;
//    $rollNum = 0;
//    foreach ( $weight as $k => $v ) {
//        $min = $_tmpW;
//        $_tmpW += $v;
//        $max = $_tmpW;
//        if ($roll > $min && $roll <= $max) {
//            $rollNum = $k;
//            break;
//        }
//    }
//    return $rollNum;
//}
//
//$row = roll(array('a'=>200,'b'=>300,'c'=>500));
//echo $row;

echo rand(0 ,2);
die;
$a = [
    [1,2,3,4],
    [11,22,33,44],
    [111,222,333,444],
    ['a',222,333,444],
    ['b',222,333,444],
];

shuffle($a);

unset($a[2]);
shuffle($a);

print_r('<pre>');
print_r($a);