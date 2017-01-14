<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <title>报单定时任务系统</title>
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

    <style type="text/css">
        .list {
            padding-top: 30px;
            font-weight: bold;
            font-style: italic;
            font-size: 15pt;
            text-decoration: underline;
        }
    </style>
</head>

<body style="background: #FDF5E6">
<div style="width: 1000px; margin: 10px auto;">
    <h3><font color="red">后台管理功能URL访问清单：</font></h3><BR>

    <div class="form-group" >
        <label class="col-sm-2 control-label list"><a href="index.php" target="_blank">XSOLLA ONLINE PAYMENT 支付</a> </label>
    </div>

    <div class="form-group " >
        <label class="col-sm-2 control-label list"><a href="randPayTask.php" target="_blank">报单定时任务系统</a> </label>
    </div>

    <div class="form-group " >
        <label class="col-sm-2 control-label list"><a href="randPayTask_fixed_pond.php" target="_blank">报单定时任务系统 - 单独配置池（1-14）</a> </label>
    </div>

    <div class="form-group " >
        <label class="col-sm-2 control-label list"><a href="excelExportData.php" target="_blank">导出EXCEL设定金额的订单（1-14）</a> </label>
    </div>

    <div style="padding-top: 50px;">
        <p><u>*仅用于模拟测试</u></p>
        <p><u>*详细使用规则，可联系MM</u></p>
    </div>
</div>

</body>
</html>