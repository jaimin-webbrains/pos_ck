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
              <a href="overview_report_branch.php" class="btn btn-info" role="button"> <i class="fa fa-list" aria-hidden="true"></i> Daily Report</a>
              <a href="overview_report_month_branch.php" class="btn btn-info" role="button"> <i class="fa fa-list" aria-hidden="true"></i> Monthly Report</a>
              <a href="overview_report_year_branch.php" class="btn btn-info" role="button"> <i class="fa fa-list" aria-hidden="true"></i> Yearly Report</a>
            </h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <!-- form start -->

            <form class="form-inline" method="post" action="overview_report_year.php">

              <div class="form-group">
                <label for="pwd">Year:</label><br/>
                <select name="search_year" class="form-control">
                  <option value="2019" >2019</option>
                  <option value="2020" >2020</option>
                  <option value="2021" >2021</option>
                  <option value="2022" >2022</option>
                  <option value="2023" >2023</option>
                  <option value="2024" >2024</option>
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
                  <th style='text-align:center;' colspan="2">Stock In</th>
                  <th style='text-align:center;'>Stock Out</th>
                  <th style='text-align:center;' colspan="2">Stock Rotate</th>
                  <th style='text-align:center;' colspan="2">Stock Wave Off</th>
                  <th style='text-align:center;'>Current Stock</th>

                </tr>

                <tr>

                  <th></th>

                  <th style='text-align:center;' >Product Sale</th>
                  <th style='text-align:center;' >Product Used</th>

                  <th></th>

                  <th style='text-align:center;' >Product Sale</th>
                  <th style='text-align:center;' >Product Used</th>

                  <th style='text-align:center;' >Product Sale</th>
                  <th style='text-align:center;' >Product Used</th>

                  <th style='text-align:center;' ></th>

                </tr>

              </thead>
              <tbody>
                <?php
                if(isset($_POST['search_year'])){
                  $current_stock = 0;
                  $month = 1;
                  while( $month <= 12 ){
                    echo "<tr>";
                    $monthNum  = $month;
                    $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                    echo "<td>".$_POST['search_year']." - ".$dateObj->format('F')."</td>";



                    $StockSaleQty = 0;
                    $StockSale = StockProductSales::find_by_month($month);
                    foreach ($StockSale as $StockSaleData) {
                      $StockSaleQty = $StockSaleQty + $StockSaleData->quantity;
                    }
                    echo "<td style='text-align:center;'>".$StockSaleQty."</td>";

                    $StockUsedQty = 0;
                    $StockUsed = StockProductUsage::find_by_month($month);
                    foreach ($StockUsed as $StockUsedData) {
                      $StockUsedQty = $StockUsedQty + $StockUsedData->quantity;
                    }
                    echo "<td style='text-align:center;'>".$StockUsedQty."</td>";

                    echo "<td style='text-align:center;'>".$StockReceiveQty."</td>";

                    $StockRotate = StockRotateSales::find_by_month($month);
                    echo "<td style='text-align:center;'>".count($StockRotate)."</td>";

                    $StockRotateUsage = StockRotateUsage::find_by_month($month);
                    echo "<td style='text-align:center;'>".count($StockRotateUsage)."</td>";

                    $StockWaveoff = StockWriteOffSales::find_by_month($month);
                    echo "<td style='text-align:center;'>".count($StockWaveoff)."</td>";

                    $StockWaveoffUsage = StockWriteOffUsage::find_by_month($month);
                    echo "<td style='text-align:center;'>".count($StockWaveoffUsage)."</td>";

                    $current_stock = $current_stock + $StockReceiveQty -( $StockSaleQty + $StockUsedQty + count($StockRotate) + count($StockRotateUsage) + count($StockWaveoff) + count($StockWaveoffUsage) );
                    echo "<td style='text-align:center;'>".$current_stock."</td>";

                    echo "</tr>";
                    ++$month;
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
