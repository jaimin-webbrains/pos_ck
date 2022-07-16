
<?php 
require_once './../../util/initialize.php';
include 'common/upper_content.php';

?><!-- upper content -->
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Leeshya</h3>
            </div>

            <div class="title_right">
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <?php 
                    Functions::output_result();
                ?>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->
<?php include 'common/bottom_content.php';?>