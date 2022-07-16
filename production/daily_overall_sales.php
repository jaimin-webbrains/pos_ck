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
            <h2 id="title" style="font-weight:700;"> - DAILY OVERALL SALES REPORT - </h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <!-- form start -->

            <form class="form-inline" method="post" action="daily_overall_sales_print.php" target="_blank">

              <div class="form-group">
                <label>YEAR:</label><br/>
                <select class="form-control" name="year">
                  <option value='2020' >2020</option>
                  <option value='2021' >2021</option>
                  <option value='2022' >2022</option>
                  <option value='2023' >2023</option>
                </select>
              </div>

              <div class="form-group">
                <label>MONTH:</label><br/>
                <select class="form-control" name="month">
                  <option value="1">JANUARY</option>
                  <option value="2">FEBRUARY</option>
                  <option value="3">MARCH</option>
                  <option value="4">APRIL</option>
                  <option value="5">MAY</option>
                  <option value="6">JUNE</option>
                  <option value="7">JULY</option>
                  <option value="8">AUGUST</option>
                  <option value="9">SEPTMBER</option>
                  <option value="10">OCTOMBER</option>
                  <option value="11">NOVEMBER</option>
                  <option value="12">DECEMBER</option>
                </select>
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
<?php include 'common/bottom_content.php'; ?> bottom content
<script>

</script>
