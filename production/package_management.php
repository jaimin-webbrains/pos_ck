<?php
require_once './../util/initialize.php';
include 'common/upper_content.php';
?>

<!--page content-->

<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3 style='font-weight:800;'>Package Management</h3>
      </div>

      <div class="title_right">

      </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <a href="package.php" target="_blank"><button id="btnNew" type="button" class="btn btn-round btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="glyphicon glyphicon-plus"></i> Add New</button></a>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>S/No</th>
                  <th>Category</th>
                  <th>Name</th>
                  <th>Code</th>
                  <th>Pre Paid Package Price</th>
                  <th>X Pre Paid Package Sales (%)</th>
                  <th>Staff 1 Commision (%)</th>
                  <th>Staff 2 Commision (%)</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

                <?php

                ?>

              </tbody>
            </table>
          </div>
        </div>
        <div class="x_panel">
          <div onclick="window.location.href:''" class="x_content">
            <?php
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<?php include 'common/bottom_content.php'; ?>
<script>
window.onfocus = function () {
};
</script>
