<head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="robots" content="noindex, nofollow">
        <title><?php echo $this->settings[Constants::KEY_SITE_NAME]; ?></title>
        <!--[if IE 7]>
        <link rel="stylesheet" href="<?php echo $this->getPackageBaseUrl() . '/css/font-awesome-ie7.min.css' ?>" />
        <![endif]-->
        <!--[if lte IE 8]>
        <link rel="stylesheet" href="<?php echo $this->getPackageBaseUrl() . '/css/ace-ie.min.css' ?>" />
        <![endif]-->
        <!--//load jquery from Google servers.-->
        <?php if (!YII_DEBUG): ?><script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script><?php endif; ?>
        <!--//fall back to a local jquery file if Google servers are unreachable-->
        <script>!window.jQuery && document.write('<script src="<?php echo $this->getPackageBaseUrl() . '/js/jquery-1.10.2.min.js' ?>"><\/script>')</script>
        <script type="text/javascript">
                if ("ontouchend" in document) {
                        document.write('<script src="<?php echo $this->getPackageBaseUrl() . '/js/jquery.mobile.custom.min.js' ?>"><\/script>');
                }
        </script>
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="<?php echo $this->getPackageBaseUrl() . '/js/html5shiv.js' ?>"></script>
        <script src="<?php echo $this->getPackageBaseUrl() . '/js/respond.min.js' ?>"></script>
        <![endif]-->
</head>