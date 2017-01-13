<html>
<head>
    <?php
    if(isset($_REQUEST['uId']) && isset($_REQUEST['itemId']) && $_REQUEST['itemId'])
    {
        ?>
        <script>
            alert('pay success!');
        </script>
    <?php
    }
    else
    {
    ?>
        <script>
            alert('pay fail!');
        </script>
    <?php
    }
    ?>
</head>
<body>
</body>
</html>
