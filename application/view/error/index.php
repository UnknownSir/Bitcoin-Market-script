
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo System::get('sitename'); ?> - Error</title>
    <link href="<?php echo Config::get('URL'); ?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo Config::get('URL'); ?>font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="<?php echo Config::get('URL'); ?>css/animate.css" rel="stylesheet">
    <link href="<?php echo Config::get('URL'); ?>css/style.css" rel="stylesheet">
</head>
<body class="gray-bg">
    <div class="middle-box text-center animated fadeInDown">
        <h1>404</h1>
        <h3 class="font-bold"><?php echo System::translate("Page Not Found"); ?></h3>
        <div class="error-desc">
            <?php echo System::translate("Sorry, but the page you are looking for has note been found. Try checking the URL for error, then hit the refresh button on your browser or try found something else in our app."); ?>
            <form class="form-inline m-t" role="form">
                <a href="<?php echo Config::get('URL'); ?>" class="btn btn-primary m-t"><?php echo System::translate("Homepage"); ?></a>
            </form>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="js/jquery-2.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
