<?php

//var_dump($_POST);
//die;
//下载当前页面数据
if(isset($_POST['downLoadCsv']) && isset($_POST['csvData'])) {
    export_csv(date('Ymd') . '-GAME(' . $_POST['gameName'] . ')' .  '.csv', trim($_POST['csvData']));die; //导出
} else {
    if(empty($_POST)) {
        echo "DATA ERROR! PLEASE VISIT : randPayTask.php";die;
    }

    //当天秒数
    $todayStart = strtotime(date('Y-m-d'));
    $todayEnd = strtotime(date('Y-m-d', strtotime("+1 day")));

//    var_dump($todayEnd - $todayStart);

    if(isset($_POST['startTime']) && $_POST['startTime']) {
        $todayStart = strtotime($_POST['startTime']);
    }

    if(isset($_POST['endTime']) && $_POST['endTime']) {
        $todayEnd = strtotime($_POST['endTime']);
    }

//    var_dump($todayEnd - $todayStart);die;

    $todayTotalSecond = $todayEnd - $todayStart;

    //全部随机玩家ID
    $userList = file('facebookId.txt');

    //订单额度
    $paymentType = ['big', 'mid', 'lit'];

    //共用浮动系数 0.2
    //$rand = floatval($_REQUEST['rand'] / 10000);

    $eTList = [
        'moneyRankList' => [],
        'totalSplit'    => 1,
    ];

    foreach($paymentType as $eT) {
        $payAmount  = intval($_REQUEST['payAmount-' . $eT]) * 10000;               //100000
        $timeSplit  = intval($_REQUEST['timeSplit-' . $eT]);                       //24
        //共用浮动系数 0.2
        $rand       = floatval($_REQUEST['rand-' . $eT] / 10000);                  //0.2

        //金额随机值
        $eTList['moneyRankList'] = array_merge($eTList['moneyRankList'], randPayTask($payAmount, $timeSplit, $rand));
        $eTList['totalSplit'] += $timeSplit;
        $eTList['rand'][] = $rand;
    }

    if(empty($eTList['moneyRankList'])) {
        echo "data error, please add the data!";die;
    }

    //打乱顺序，看上去更真实一点
    shuffle($eTList['moneyRankList']);

    //时间随机值
    $timeRankList = randPayTask($todayTotalSecond, $eTList['totalSplit'], isset($_POST['rand-time']) ? floatval($_POST['rand-time'] / 10000) : 0);

    //展示数据
    $showPageIndex = showPageIndex($userList, $eTList['moneyRankList'], $timeRankList, $todayTotalSecond);
    $indexList = $showPageIndex['list'];
    $csvString = $showPageIndex['string'];

}

//----------------------------方法体----------------------------------------------
/**
 * 导出csv
 * @param $filename
 * @param $data
 */
function export_csv($filename, $data)
{
    header("Content-type:text/csv");
    header("Content-Disposition:attachment;filename=" . $filename);
    header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
    header('Expires:0');
    header('Pragma:public');
    echo $data;
}

/**
 * 拼接
 * @param $userList
 * @param $moneyRankList
 * @param $timeRankList
 * @param $todayTotalSecond
 * @return array
 */
function showPageIndex($userList, $moneyRankList, $timeRankList, $todayTotalSecond = 86400) {
    $maxNum = count($timeRankList);
    if($maxNum < 3) {
        $lastTimeSet = 0;
    } else {
        $lastTimeSet = rand($timeRankList[$maxNum - 2], $timeRankList[$maxNum - 3]);
    }

    //特殊处理订单开始时间
    if(isset($_POST['startTime']) && $_POST['startTime']) {
        $startDay = strtotime($_POST['startTime']);
    } else {
        $startDay = strtotime(date('Y-m-d'));
    }
    $csvString = 'num,uid,time,money,type' . PHP_EOL;
    $indexList = [];
    $addTime = 0;
    $maxFbNum = count($userList);

    //拆分订单数量
    $csvSheet = isset($_POST['csvSheet']) ? intval($_POST['csvSheet']) : 1;

    //拼index
    $num = 0;
    foreach($moneyRankList as $key => $value) {
        //这里这么设定完全为了服务最后一个时间，显示不同的时间
        if($num == $maxNum) {
            $addTime += $timeRankList[$key];
        } else {
            $addTime += $lastTimeSet;
        }

        $addTime = $addTime > $todayTotalSecond ? $todayTotalSecond : $addTime;
        $nowTime = $startDay + $addTime;

        $uId = substr(trim($userList[rand(0, $maxFbNum - 1)]), 0, -3);
        $time = date('Y-m-d H:i:s', $nowTime);
        $type = ($num + 1) % $csvSheet;
        $indexList[] = [
            'num'   => $num + 1,
            'uid'   => $uId,
            'time'  => $time,
            'money' => $value,
            'type'  => $type + 1,
        ];


        $csvString .= $num + 1 . "," . $uId . ',' . $time . ',' . $value . ',' . ($type + 1) . PHP_EOL;

        $num ++;
    }

    return [
        'list'      => $indexList,
        'string'    => $csvString,
    ];
}

/**
 * 计算随机值（平均和随机值）（金额和时间）
 * @param $payAmount
 * @param $timeSplit
 * @param $rand
 * @return array
 */
function randPayTask($payAmount, $timeSplit, $rand) {
    if(!$payAmount || !$timeSplit) {
        return [];
    }

    //计算开始
    $BS = 5;    //结果值用当前值取整
    $pieceMoney = intval($payAmount / $timeSplit);
    $pieceMoneyList = array_pad([], $timeSplit, $pieceMoney);

    //调整系数
    $pieceMoneyList_2 = [];
    foreach($pieceMoneyList as $moneyVal) {
        if(rand(1, 100) > 50) {
            $pieceMoneyList_2[] = intval($moneyVal * (1 + $rand));
        } else {
            $pieceMoneyList_2[] = intval($moneyVal * (1 - $rand));
        }
    }

    //计算超过了多少值
    $overMoney = array_sum($pieceMoneyList_2) - $payAmount;
    $overMoneyAverage = intval($overMoney / $timeSplit);
    if($overMoney > 0) {
        //说明值大了，需要扣去
        $isAdd = false;
    } else {
        //说明值小了，直接相加
        $isAdd = true;
    }

    //继续平均分配这些值
    foreach($pieceMoneyList_2 as $key => $moneyVal) {
        if($isAdd) {
            $pieceMoneyList_2[$key] += abs($overMoneyAverage);
        } else {
            if($pieceMoneyList_2[$key] - abs($overMoneyAverage) < 0) {
                $pieceMoneyList_2[$key] = 0;    
            } else {            
                $pieceMoneyList_2[$key] -= abs($overMoneyAverage);
            }
        }

        if($BS) {
            $pieceMoneyList_2[$key] = round($pieceMoneyList_2[$key] / $BS) * $BS;
        }
    }

    //查漏补缺小数据，直接补第一个值
    $overMoney = array_sum($pieceMoneyList_2) - $payAmount;

    if($overMoney > 0) {
        //说明值大了，需要扣去
        if($pieceMoneyList_2[0] - abs($overMoney) < 0) {
            $pieceMoneyList_2[0] = 0;    
        } else {            
            $pieceMoneyList_2[0] -= abs($overMoney);
        }
    } else {
        //说明值小了，直接相加
        $pieceMoneyList_2[0] += abs($overMoney);
    }

    return $pieceMoneyList_2;
}
//----------------------------方法体----------------------------------------------
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <title>报单定时任务系统 - 生成的全部订单</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <!-- 新 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="resource/bootstrap.min.css">

    <!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
    <script src="resource/jquery.min.js"></script>

    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <script src="resource/bootstrap.min.js"></script>

    <script type="text/javascript"></script>
</head>

<body style="background: #FDF5E6">
<div style="width: 1000px; margin: 10px auto;">
    <h3><font color="red">报单定时任务系统 1.1  -  生成的全部订单</font></h3><BR>

    <div style="border: 1px solid #ccc;">
        <form class="form-horizontal" name= "randPayTask-form" action="payTask.php" method="post" target="_blank">

            <div class="form-group" style="padding-top: 10px;">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-10" style="text-align: right;">
                    <button type="button" class="btn btn-danger" onclick="this.form.submit()" style="width: 250px;" name="downLoadCsv">下载全部报单</button>
                    <input type="hidden" name="csvData" value="<?php echo $csvString;?>" />
                    <input type="hidden" name="gameName" value="<?php echo $_POST['gameName'];?>" />
                    <input type="hidden" name="downLoadCsv" value="1" />&nbsp;&nbsp;
                </div>
            </div>

        </form>

        <table class="table table-hover">
            <tr>
                <td class="danger"><b>ID</b></td>
                <td class="danger"><b>用户ID</b></td>
                <td class="danger"><b>执行时间</b></td>
                <td class="danger"><b>订单金额</b></td>
            </tr>
            <?php
            foreach($indexList as $listValue) {
                echo "<tr>";
                foreach($listValue as $key => $value) {
                    if($key == 'type') continue;
                    echo "<td>" . $value . "</td>";
                }
                echo "</tr>";
            }
            ?>
        </table>
    </div>

</div>
</body>
</html>
