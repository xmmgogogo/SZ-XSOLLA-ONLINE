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
    <h3><font color="red">报单定时任务系统 1.1</font></h3><BR>

    <form class="form-horizontal" name= "randPayTask-form" action="payTask.php" method="post" target="_blank">

        <div class="form-group" style="padding-top: 5px;">
            <label class="col-sm-2 control-label">设置时间（开始/结束）：</label>
            <div class="col-sm-2">
                <div class="control-group">
                    <div class="controls input-append date form_time" data-date="" data-date-format="yyyy-mm-dd hh:ii" data-link-field="dtp_input3" data-link-format="hh:ii" style="margin-left: 0;">
                        <input size="16" type="text" name="startTime" id="startTime" value="<?php echo date('Y-m-d H:i', strtotime(date('Y-m-d')));?>" readonly style="width: 150px"/>
                        <span class="add-on"><i class="icon-remove"></i></span>
                        <span class="add-on"><i class="icon-th"></i></span>
                    </div> /
                    <div class="controls input-append date form_time" data-date="" data-date-format="yyyy-mm-dd hh:ii" data-link-field="dtp_input3" data-link-format="hh:ii" style="margin-left: 0;">
                        <input size="16" type="text" name="endTime" id="endTime" value="<?php echo date('Y-m-d H:i', strtotime(date('Y-m-d', strtotime("+1 day"))));?>" readonly  style="width: 150px"/>
                        <span class="add-on"><i class="icon-remove"></i></span>
                        <span class="add-on"><i class="icon-th"></i></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group" style="padding-bottom: 10px;">
            <label class="col-sm-2 control-label">时间浮动系数：</label>
            <div class="col-sm-10">
                <input type="number" name="rand-time" id="rand-time" value="" class="form-control" placeholder="针对时间，值越大波动越大，推荐1~500." style="width: 30%;">
            </div>
        </div>

        <div id="content">
            <fieldset>
                <legend>大额订单</legend>

                <div class="form-group" style="padding-bottom: 10px;">
                    <label class="col-sm-2 control-label">报单金额（万）：</label>
                    <div class="col-sm-10">
                        <input type="number" name="payAmount-big" id="payAmount-big" value="" class="form-control" placeholder="输入金额，单位万." style="width: 30%;">
                    </div>
                </div>

                <div class="form-group" style="padding-bottom: 10px;">
                    <label class="col-sm-2 control-label">数量：</label>
                    <div class="col-sm-10">
                        <input type="number" name="timeSplit-big" id="timeSplit-big" value="" class="form-control" placeholder="输入生成多少比订单." style="width: 30%;">
                    </div>
                </div>

                <div class="form-group" style="padding-top: 10px;">
                    <label class="col-sm-2 control-label">浮动系数（万分比）：</label>
                    <div class="col-sm-10">
                        <input type="number" name="rand-big" id="rand-big" value="" class="form-control" placeholder="值越大波动越大，推荐1~500." style="width: 30%;">
                    </div>
                </div>

            </fieldset>
        </div>

        <div id="content">
            <fieldset>
                <legend>中额订单</legend>
                <form class="form-horizontal" name= "randPayTask-form" action="payTask.php" method="post" target="_blank">

                    <div class="form-group" style="padding-bottom: 10px;">
                        <label class="col-sm-2 control-label">报单金额（万）：</label>
                        <div class="col-sm-10">
                            <input type="number" name="payAmount-mid" id="payAmount-mid" value="" class="form-control" placeholder="输入金额，单位万." style="width: 30%;">
                        </div>
                    </div>

                    <div class="form-group" style="padding-bottom: 10px;">
                        <label class="col-sm-2 control-label">数量：</label>
                        <div class="col-sm-10">
                            <input type="number" name="timeSplit-mid" id="timeSplit-mid" value="" class="form-control" placeholder="输入生成多少比订单." style="width: 30%;">
                        </div>
                    </div>

                    <div class="form-group" style="padding-top: 10px;">
                        <label class="col-sm-2 control-label">浮动系数（万分比）：</label>
                        <div class="col-sm-10">
                            <input type="number" name="rand-mid" id="rand-mid" value="" class="form-control" placeholder="值越大波动越大，推荐1~500." style="width: 30%;">
                        </div>
                    </div>
            </fieldset>
        </div>

        <div id="content">
            <fieldset>
                <legend>小额订单</legend>
                <form class="form-horizontal" name= "randPayTask-form" action="payTask.php" method="post" target="_blank">

                    <div class="form-group" style="padding-bottom: 10px;">
                        <label class="col-sm-2 control-label">报单金额（万）：</label>
                        <div class="col-sm-10">
                            <input type="number" name="payAmount-lit" id="payAmount-lit" value="" class="form-control" placeholder="输入金额，单位万." style="width: 30%;">
                        </div>
                    </div>

                    <div class="form-group" style="padding-bottom: 10px;">
                        <label class="col-sm-2 control-label">数量：</label>
                        <div class="col-sm-10">
                            <input type="number" name="timeSplit-lit" id="timeSplit-lit" value="" class="form-control" placeholder="输入生成多少比订单." style="width: 30%;">
                        </div>
                    </div>

                    <div class="form-group" style="padding-top: 10px;">
                        <label class="col-sm-2 control-label">浮动系数（万分比）：</label>
                        <div class="col-sm-10">
                            <input type="number" name="rand-lit" id="rand-lit" value="" class="form-control" placeholder="值越大波动越大，推荐1~500." style="width: 30%;">
                        </div>
                    </div>
            </fieldset>
        </div>


        <div class="form-group" style="padding-top: 10px;">
            <label class="col-sm-2 control-label">报单数量：</label>
            <div class="col-sm-10">
                <input type="number" name="csvSheet" id="csvSheet" value="1" class="form-control" placeholder="" style="width: 30%;">
            </div>
        </div>

        <div class="form-group" style="padding-top: 10px;">
            <label class="col-sm-2 control-label">公司游戏：</label>
            <div class="col-sm-10">
                <select class="form-control" style="width: 210px;" name="gameName"  id="gameName">
                    <option value="A">游戏A</option>
                    <option value="B" selected>游戏B</option>
                    <option value="C">游戏C</option>
                </select>
            </div>
        </div>

        <div class="form-group" style="padding-top: 10px;">
            <label class="col-sm-2 control-label"></label>
            <div class="col-sm-10">
                <button type="button" class="btn btn-danger" onclick="this.form.submit()" style="width: 250px;">创建全部报单</button>
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