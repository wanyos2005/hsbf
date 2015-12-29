<html>
    <head>

    </head>

    <body>
        test
        <p style="font-family:verdana">
            Kind regards
            <br />
            <br />
            <?php echo Yii::app()->params['adminName']; ?>

            Send on:<?php echo date('l jS \of F Y h:i:s A'); ?>
        </p>
    </body>
</html>