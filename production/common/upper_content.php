<?php
require_once __DIR__ . '/../../util/validate_login.php';
require_once __DIR__ . '/../../util/initialize.php';
include __DIR__ . '/head.php';
?>
<!-- head -->

<body class="nav-md">
    <!--<div id="ajaxLoader" class="ajax_loader"><i class="fa fa-spin fa-spinner fa-4x fa-fw" aria-hidden="true"></i></div>-->
    <div id="ajaxLoader" class="ajaxLoader ajax_loader_outer">
        <div class="ajax_loader">
            <!--<img style="width: 50px; height: auto;" src="./images/Spinner.gif" />-->
            <i class="fa fa-spin fa-spinner fa-3x fa-fw" aria-hidden="true"></i><label>Loading... </label>
        </div>
    </div>
    <div class="container body">
        <div class="main_container">
            <?php
            //sidebar menu
            include __DIR__.'/side_bar.php';
            //top navigation
            include __DIR__.'/top_navigation.php';
            ?>

