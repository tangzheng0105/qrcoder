<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <title>支付宝支付</title>
    <style type="text/css">
        * {
            padding: 0;
            margin: 0;
        }

        body {
            font-size: 12px;
            color: #333;
            font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Helvetica, PingFang SC, Hiragino Sans GB, Microsoft YaHei, SimSun, sans-serif;
        }

        button,
        input,
        select {
            background: none;
            outline: none;
            -webkit-appearance: none !important;
        }

        html,
        body,
        .app {
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .app {
            background: #e61a3b;
        }

        .title {
            font-size: 18px;
            color: #fde345;
            font-weight: bold;
            text-align: center;
            padding: 35px 0;
        }

        .text_1 {
            line-height: 24px;
            text-align: center;
            margin-bottom: 20px;
        }

        .text_1 a {
            color: #fff;
            font-size: 18px;
            text-decoration: underline;
        }

        .text_2 {
            width: 80%;
            line-height: 24px;
            margin: 0 auto;
            color: #fff;
            font-size: 18px;
        }

        .timer {
            position: fixed;
            left: 0;
            bottom: 80px;
            width: 100%;
            text-align: center;
            font-size: 16px;
            color: #fff;
        }

        .open_obtain_redEnvelopes {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 50px;
            line-height: 50px;
            font-size: 18px;
            font-weight: bold;
            color: #e61a3b;
            text-align: center;
            background: #fde345;
        }

        .tag {
            display: block;
            width: 100px;
            height: 100px;
            margin: 0 auto 75px auto;
        }
    </style>
</head>

<body>
    <div class="app" id="app" onclick="openObtainRedEnvelopes()">
        <div class="title">该商家已开通红包抵现功能</div>
        <img class="tag" onclick="openObtainRedEnvelopes()" src="/pay/assets/img/99-2.png?v=3" />
        <div class="text_1">
            <a href="javascript:;" onclick="openObtainRedEnvelopes()">点击领取</a>
        </div>
        <div class="text_2">红包抵现最高可达99元，最后一个月疯狂送红包，错过就不再等待！</div>
        <div class="timer">正在跳转支付宝支付
            <span id="timer"></span>秒</div>
        <div class="open_obtain_redEnvelopes" onclick="openObtainRedEnvelopes()">立即领红包，抵现金</div>
    </div>
    <script src="/pay/assets/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/pay/assets/js/jquery.cookie.js" type="text/javascript" charset="utf-8"></script>
    <script src="/pay/assets/js/wechat.js?ver=20180329" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
        var i = 4;
        var timer = null;
        var time = new Date();
        var timeStr = time.getFullYear() + "-" + (time.getMonth() + 1) + "-" + time.getDate();
        var obtainRedEnvelopesTime = $.cookie('obtainRedEnvelopesTime');

        $('#timer').text(i);
        timer = setInterval(function () {
            i--;
            $('#timer').text(i);
            if (i == 0) {
                clearInterval(timer);
                window.location.href = "<?php echo $redbag_url;?>";
            }
        }, 1000);

        function openObtainRedEnvelopes() {
            $.cookie('obtainRedEnvelopesTime', timeStr, { expires: 1 });
            //判断该用户今天是否已经领了改红包，写入cookie,过期时间1天
            var access_key = '97250096';
            var cookieName = 'hasDonate' + access_key;
            $.cookie(cookieName, '1', { expires: 1 });
            window.location.href = "<?php echo $pay_url;?>";
        }
    </script>
</body>

</html>