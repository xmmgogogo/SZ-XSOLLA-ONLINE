<?php

/**
 * <!--从excel文件里面随机选出设置的金额，excel格式为csv格式！！！！！-->
 */

/**
 * 导出excel
 * @param $filename
 * @param $data
 */
function export_csv($filename, $data)
{
    header("Content-type:text/csv");
    header("Content-Disposition:attachment;filename=".$filename);
    header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
    header('Expires:0');
    header('Pragma:public');
    echo $data;
}

//判断是否开始导入
if(isset($_POST['set-amount']) && isset($_FILES["excel-name"])) {
    if($_POST['set-amount'] > 0 && $_FILES["excel-name"]['error'] == 0) {
        //判断文件类型，只能处理excel
        //application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
        //application/vnd.ms-excel
        $FILE = $_FILES["excel-name"];
        if($FILE['type'] == 'application/vnd.ms-excel') {
            if(file_exists($FILE['tmp_name'])) {
                $file = fopen($FILE['tmp_name'],'r');

                $line = 1;
                $str = '';
                while ($data = fgetcsv($file)) { //每次读取CSV里面的一行内容
                    if($line == 1) {
                        //获取首行字段名，可能是中文，这里需要转义
//                        $str = iconv('utf-8', 'gb2312', implode(',', $data));
                        $str .= implode(',', $data) . PHP_EOL;
                    } else {
                        $goods_list[] = $data;
                    }

                    $line++;
                }

                //匹配总设置金额100W
                $setAmount = intval($_POST['set-amount']);
                $curAmount = 0;

                $maxLine = count($goods_list);
                $selectLine = [];
                while($curAmount < $setAmount) {
                    shuffle($goods_list);
                    $r = rand(0, $maxLine - 1);
                    if($goods_list[$r][0]) {
                        //每一单的金额项
                        $curAmount += $goods_list[$r][2];
                        //存入记录
                        $selectLine[] = $goods_list[$r];
                        //同时删除当前选项，避免重复
                        unset($goods_list[$r]);
                    }

                    $maxLine--;
                    if($maxLine == 0) {
                        break;
                    }
                }

                //存入excel，进行csv拼接
                foreach($selectLine as $value) {
                    $str .= implode(',', $value) . PHP_EOL;
                }

                //设置文件名
                $filename = 'paymentList(SetAmount' . $setAmount . '#nowAmount' . $curAmount . ').csv';
                //导出
                export_csv($filename, $str);die;

                fclose($file);
            } else {
                die("文件已丢失！");
            }
        } else {
            die("导入类型不是Excel类型！");
        }
    } else {
        die("导入文件失败 or 设置金额有误！");
    }
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <title>导出EXCEL设定金额的订单</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <!-- 新 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="resource/bootstrap.min.css">
    <link rel="stylesheet" href="resource/bootstrap-datetimepicker.css"  media="screen">

    <!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
    <script src="resource/jquery.min.js"></script>

    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <script src="resource/bootstrap.min.js"></script>

    <script src="resource/bootstrap-datetimepicker.js" charset="UTF-8"></script>
    <script src="resource/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>

    <style type="text/css">
        #content {
            border: 1px solid #ccc;
            margin-bottom: 10px;
            padding: 10px;
        }
    </style>
</head>

<body style="background: #FDF5E6">
<div style="width: 1000px; margin: 10px auto;">
    <h3><font color="red">导出EXCEL设定金额的订单 - 1.0</font></h3><BR>

    <form class="form-horizontal" name= "excelExport-form" action="excelExportData.php" method="post" enctype="multipart/form-data" target="_blank">

    <div class="form-group" style="padding-bottom: 20px;padding-top: 50px;">
        <label class="col-sm-2 control-label">请选择导入Excel(*csv)：</label>
        <div class="col-sm-10">
            <input type="file" name="excel-name" id="excel-name" value="" class="" placeholder="选择导入的Excel." style="width: 30%;">
        </div>
    </div>

    <div class="form-group" style="padding-bottom: 20px;">
        <label class="col-sm-2 control-label">设置目标金额(整数)：</label>
        <div class="col-sm-10">
            <input type="number" name="set-amount" id="set-amount" value="2000" class="form-control" placeholder="设置目标金额." style="width: 30%;">*
        </div>
    </div>

    <div class="form-group" style="padding-top: 10px;">
        <label class="col-sm-2 control-label"></label>
        <div class="col-sm-10">
            <button type="button" class="btn btn-danger" onclick="this.form.submit()" style="width: 150px;">创建Excel</button>
        </div>
    </div>

    </form>

    <div style="padding-top: 20px;">
        <p><u>*仅用于模拟测试</u></p>
        <p><u>*详细使用规则，可联系MM</u></p>
    </div>
</div>

<script type="text/javascript">
    $('.form_time').datetimepicker({
        language:  'zh-CN',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 1,
        minView: 0,
        maxView: 1,
        forceParse: 0
    });
</script>
</body>
</html>