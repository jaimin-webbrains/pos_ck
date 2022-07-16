<?php
require_once './../util/initialize.php';
include 'common/upper_content.php';
?>

<!--page content-->
<div class="right_col" role="main">
  <div class="">

    <?php Functions::output_result(); ?>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2 id="title" style="font-weight:700;"> - STOCK IN ( PRODUCT SALES ) -
              <a href="stock_in.php" class="btn btn-info" role="button"> <i class="fa fa-list" aria-hidden="true"></i> Daily Report</a>
              <a href="stock_in_monthly.php" class="btn btn-info" role="button"> <i class="fa fa-list" aria-hidden="true"></i> Monthly Report</a>
            </h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <!-- form start -->

            <form class="form-inline" method="post" action="stock_in_report.php" target="_blank">

              <div class="form-group">
                <label for="pwd">Branch:</label><br/>
                <select class="form-control" name="branch_id">
                  <?php
                  foreach(Branch::find_all() as $branch){
                    echo "<option value='".$branch->id."'>".$branch->name."</option>";
                  }
                  ?>
                </select>
              </div>

              <div class="form-group">
                <label for="pwd">From Date:</label><br/>
                <input type="date" class="form-control" name="search_date" required>
              </div>

              <div class="form-group">
                <label for="pwd">To Date:</label><br/>
                <input type="date" class="form-control" name="search_date_to" required>
              </div>

              <div class="form-group">
                <br/>
                <button type="submit" class="btn btn-primary">FIND</button>
              </div>


            </form>

            <!-- form ends -->
          </div>
        </div>
      </div>

      <!-- SECOND COLUMN -->

      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_content">



          </div>
        </div>
      </div>



    </div>
  </div>
</div>
<!--/page content-->
<?php include 'common/bottom_content.php'; ?>
