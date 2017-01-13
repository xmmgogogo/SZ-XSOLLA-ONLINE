<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <title>XSOLLA ONLINE PAYMENT 1.0</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <!-- 新 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="resource-for-index/bootstrap.min.css">

    <!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
    <script src="resource-for-index/jquery.min.js"></script>

    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <script src="resource-for-index/bootstrap.min.js"></script>

    <script type="text/javascript">
        var platformId  = 110;      //addicting
        var itemId      = 300050;   //自定义道具ID

        //提交订单
        function szFormSubmit() {
            var uId         = $('#facebookId')[0].value;
            var current     = $('#current option:selected').text();
            var payAmount   = $('#payAmount')[0].value;
            var extraMsg    = $('#extraMsg')[0].value;

//            location.href = "xsollaGoPay.php?platformId=" + platformId + "&uId=" + uId + "&configId=" + itemId + "&buyNum=0";
            window.open("xsollaGoPay.php?platformId=" + platformId + "&uId=" + uId + "&configId=" + itemId + "&current=" + current + "&payAmount=" + payAmount + "&extraMsg=" + extraMsg, "_blank");
        }

        //设置固定金额
        function resetMoney(num) {
            document.getElementById("payAmount").value = num;
        }
    </script>
</head>

<body style="background: #FDF5E6">
    <div style="width: 1000px; margin: 100px auto;">
        <h3><font color="red">XSOLLA ONLINE PAYMENT 1.0</font></h3><BR>

        <div style="border: 1px solid #ccc;">
            <form class="form-horizontal" name= "xsolla-form" action="" method="post">
                <div class="form-group" style="padding-top: 10px;">
                    <label class="col-sm-2 control-label">用户ID：</label>
                    <div class="col-sm-10">
                        <input type="text" name="facebookId" id="facebookId" value="" class="form-control" placeholder="输入用户ID" style="width: 25%;">
                    </div>
                </div>

                <div class="form-group" style="padding-top: 10px;">
                    <label class="col-sm-2 control-label">充值金额：</label>
                    <div class="col-sm-10">
                        <input type="text" name="payAmount" id="payAmount" value="10" class="form-control" placeholder="输入金额" style="width: 25%;">
                        <br>
                        <button type="button" class="btn btn-primary" onclick="resetMoney(10)">10</button>&nbsp;&nbsp;&nbsp;
                        <button type="button" class="btn btn-primary" onclick="resetMoney(20)">20</button>&nbsp;&nbsp;&nbsp;
                        <button type="button" class="btn btn-primary" onclick="resetMoney(50)">50</button>&nbsp;&nbsp;&nbsp;
                        <button type="button" class="btn btn-primary" onclick="resetMoney(100)">100</button>&nbsp;&nbsp;&nbsp;
                        <button type="button" class="btn btn-primary" onclick="resetMoney(200)">200</button>&nbsp;&nbsp;&nbsp;
                        <button type="button" class="btn btn-primary" onclick="resetMoney(500)">500</button>&nbsp;&nbsp;&nbsp;
                        <button type="button" class="btn btn-primary" onclick="resetMoney(1000)">1000</button>&nbsp;&nbsp;&nbsp;
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">选择币种：</label>
                    <div class="col-sm-10">
                        <div class="row">
                            <div class="col-xs-5" style="width: 26%;">
                                <select class="form-control" style="width: 210px;" name="current"  id="current">
                                    <option value="EUR">EUR</option>
                                    <option value="USD" selected>USD</option>
                                    <option value="VND">VND</option>
                                    <option value="RUB">RUB</option>
                                    <option value="IDR">IDR</option>
                                    <option value="KRW">KRW</option>
                                    <option value="TRY">TRY</option>
                                    <option value="HKD">HKD</option>
                                    <option value="PHP">PHP</option>
                                    <option value="PHP">PHP</option>
                                    <option value="CAD">CAD</option>
                                    <option value="TWD">TWD</option>
                                    <option value="AZN">AZN</option>
                                    <option value="CC">CC</option>
                                    <option value="BYN">BYN</option>
                                    <option value="IDR">IDR</option>
                                    <option value="MYR">MYR</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group" style="padding-top: 10px;">
                    <label class="col-sm-2 control-label">备注信息：</label>
                    <div class="col-sm-4">
                        <textarea name="extraMsg" id="extraMsg" class="form-control" rows="3" placeholder="重要信息（必填）"></textarea>
                    </div>
                </div>

                <div class="form-group" style="padding-top: 10px;">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-sm-10">
                        <button type="button" class="btn btn-danger" onclick="szFormSubmit()">提交订单</button>
                    </div>
                </div>
            </form>
        </div>

        <div style="padding-top: 20px;">
            <p><u>*仅用于模拟测试</u></p>
            <p><u>*详细使用规则，可联系MM</u></p>
        </div>
    </div>
</body>
</html>