<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo $template_title ?></title>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="">
    <link rel="apple-touch-icon" href="../img/logo.png">
    <!-- Place favicon.ico in the root directory -->
    <?php echo $template_css; ?>

</head>

<body class="hold-transition login-page">
    <?php echo $template_content; ?>
    <?php echo $template_js; ?>
    <script type="text/javascript">
        $(function() {
            $("#login-form").validate({
                rules: {
                    login_username: "required",
                    login_password: "required",
                },
                messages: {
                    login_username: "Enter Username",
                    login_password: "Enter password",
                }
            });
        })
    </script>
</body>

</html>