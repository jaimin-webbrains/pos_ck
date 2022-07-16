<?php
//    require_once './../util/initialize.php';
    session_start();
    require_once './../util/project_config.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title><?php echo ProjectConfig::$project_name; ?> - Control panel | </title>

        <!-- Bootstrap -->
        <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <!-- NProgress -->
        <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
        <!-- Animate.css -->
        <link href="../vendors/animate.css/animate.min.css" rel="stylesheet">

        <!-- Custom Theme Style -->
        <link href="../build/css/custom.min.css" rel="stylesheet">
        <link href="./css/custom_style.css" rel="stylesheet">
    </head>

    <body class="login">
        <div>
            <a class="hiddenanchor" id="signup"></a>
            <a class="hiddenanchor" id="signin"></a>

            <div class="login_wrapper">
                <div class="animate form login_form">
                    <section class="login_content">
                        <form action="proccess/login_proccess.php" method="POST">
                            <h1>Login</h1>

                            <div class="form-group">

                                <?php
                                    if(isset($_SESSION["error"])){
                                        echo "<div id=\"error\" class=\"login_notify\"><h5> {$_SESSION["error"]}</h5> </div>";
                                        unset($_SESSION["error"]);
                                    }
                                    if(isset($_SESSION["message"])){
                                        echo "<div id=\"message\" class=\"login_notify\"><h5> {$_SESSION["message"]} </h5></div>";
                                        unset($_SESSION["message"]);
                                    }

                                ?>
                            </div>

                            <div>
                                <input type="text" class="form-control" placeholder="Username" name="username" required="" value="" autofocus=""/>
                            </div>
                            <div>
                                <input type="password" class="form-control" placeholder="Password" name="password" required="" value="" />
                            </div>
                            <div>
                                <button type="submit" name="submit" class="btn btn-primary btn-round btn-block submit" >Log in</button>
                            </div>

                            <div class="clearfix"></div>

                            <div class="separator">
                                <div class="clearfix"></div>
                                <br />

                                <div>
                                    <h1 style="font-weight:800;"><?php echo ProjectConfig::$project_name; ?></h1>
                                    <p>©2017 All Rights Reserved. <?php echo ProjectConfig::$project_name; ?> - Control panel by AIT</p>
                                </div>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </body>
</html>
