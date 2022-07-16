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
            <h2 id="title" style="font-weight:700;"> - OVERVIEW REPORT -
              <a href="overview_report.php" class="btn btn-info" role="button"> <i class="fa fa-list" aria-hidden="true"></i> Daily Report</a>
              <a href="overview_report_month.php" class="btn btn-info" role="button"> <i class="fa fa-list" aria-hidden="true"></i> Monthly Report</a>
              <a href="overview_report_year.php" class="btn btn-info" role="button"> <i class="fa fa-list" aria-hidden="true"></i> Yearly Report</a>
            </h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <!-- form start -->

            <form class="form-inline" method="post" action="overview_report_month.php">

              <div class="form-group">
                <label for="pwd">Month:</label><br/>
                <select name="search_month" class="form-control">
                  <option value="1" >January</option>
                  <option value="2" >February</option>
                  <option value="3" >March</option>
                  <option value="4" >April</option>
                  <option value="5" >May</option>
                  <option value="6" >June</option>
                  <option value="7" >July</option>
                  <option value="8" >August</option>
                  <option value="9" >Septmber</option>
                  <option value="10" >Octomber</option>
                  <option value="11" >November</option>
                  <option value="12" >December</option>
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
            <!-- table start -->

            <table class="table table-bordered">
              <thead>
                <tr>

                  <th>Date</th>
                  <th style='text-align:center;'>Stock In</th>
                  <th style='text-align:center;' colspan="2">Stock Out</th>
                  <th style='text-align:center;' colspan="2">Stock Rotate</th>
                  <th style='text-align:center;' colspan="2">Stock Wave Off</th>
                  <th style='text-align:center;'>Current Stock</th>

                </tr>

                <tr>

                  <th></th>
                  <th></th>

                  <th style='text-align:center;' >Product Sale</th>
                  <th style='text-align:center;' >Product Used</th>

                  <th style='text-align:center;' >Product Sale</th>
                  <th style='text-align:center;' >Product Used</th>

                  <th style='text-align:center;' >Product Sale</th>
                  <th style='text-align:center;' >Product Used</th>

                  <th style='text-align:center;' ></th>

                </tr>

              </thead>
              <tbody>
                <?php
                if(isset($_POST['search_month'])){

                  $list=array();
                  $month = $_POST['search_month'];
                  $year = date("Y");
                  $current_stock = 0;
                  for($d=1; $d<=31; $d++)
                  {
                    $time=mktime(12, 0, 0, $month, $d, $year);
                    if (date('m', $time)==$month)
                    $search_date=date('Y-m-d', $time);


                  echo "<tr>";
                  echo "<td>".$search_date."</td>";

                  $StockReceiveQty = 0;
                  $StockReceive = StockReceive::find_by_date($search_date);
                  foreach ($StockReceive as $StockReceiveData) {
                    $StockReceiveQty = $StockReceiveQty + $StockReceiveData->quantity;
                  }
                  echo "<td style='text-align:center;'>".$StockReceiveQty."</td>";

                  $StockSaleQty = 0;
                  $StockSale = StockProductSales::find_by_date($search_date);
                  foreach ($StockSale as $StockSaleData) {
                    $StockSaleQty = $StockSaleQty + $StockSaleData->quantity;
                  }
                  echo "<td style='text-align:center;'>".$StockSaleQty."</td>";

                  $StockUsedQty = 0;
                  $StockUsed = StockProductUsage::find_by_date($search_date);
                  foreach ($StockUsed as $StockUsedData) {
                    $StockUsedQty = $StockUsedQty + $StockUsedData->quantity;
                  }
                  echo "<td style='text-align:center;'>".$StockUsedQty."</td>";

                  $StockRotate = StockRotateSales::find_by_date($search_date);
                  echo "<td style='text-align:center;'>".count($StockRotate)."</td>";

                  $StockRotateUsage = StockRotateUsage::find_by_date($search_date);
                  echo "<td style='text-align:center;'>".count($StockRotateUsage)."</td>";

                  $StockWaveoff = StockWriteOffSales::find_by_date($search_date);
                  echo "<td style='text-align:center;'>".count($StockWaveoff)."</td>";

                  $StockWaveoffUsage = StockWriteOffUsage::find_by_date($search_date);
                  echo "<td style='text-align:center;'>".count($StockWaveoffUsage)."</td>";

                  $current_stock = $current_stock + $StockReceiveQty -( $StockSaleQty + $StockUsedQty + count($StockRotate) + count($StockRotateUsage) + count($StockWaveoff) + count($StockWaveoffUsage) );
                  echo "<td style='text-align:center;'>".$current_stock."</td>";
                  echo "</tr>";
                  }
                }
                ?>
              </tbody>
            </table>

            <!-- table ends -->
          </div>
        </div>
      </div>



    </div>
  </div>
</div>
<!--/page content-->
<?php include 'common/bottom_content.php'; ?>
