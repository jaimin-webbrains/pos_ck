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

            <form class="form-inline" method="post" action="overview_report_branch.php">

              <div class="form-group">
                <label for="pwd">Branch:</label><br/>
                <select class="form-control" name="branch">
                  <?php
                  foreach( Branch::find_all() as $branch ){
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
                if( isset($_POST['search_date']) && isset($_POST['search_date_to']) && isset($_POST['branch']) ){

                  $current_stock = 0;

                  echo "<tr>";
                  echo "<td>".$_POST['search_date']." - ".$_POST['search_date_to']."</td>";


                  echo "<td style='text-align:center;'>";
                  $StockSale = StockProductSales::find_by_dates($_POST['search_date'] ,$_POST['search_date_to'], $_POST['branch']);
                  foreach ($StockSale as $StockSaleData) {
                    echo $StockSaleData->p_code." , ";
                    $current_stock = $current_stock + 1;
                  }

                  echo "</td>";
                  // echo "<td style='text-align:center;'>".$StockSaleQty."</td>";

                  echo "<td style='text-align:center;'>";
                  $StockUsed = StockProductUsage::find_by_dates($_POST['search_date'],$_POST['search_date_to'], $_POST['branch']);
                  foreach ($StockUsed as $StockUsedData) {
                    echo $StockSaleData->p_code." , ";
                    $current_stock = $current_stock + 1;
                  }
                  echo "</td>";

                  echo "<td style='text-align:center;'>";
                  foreach( Invoice::find_all_by_date_range_banch($_POST['search_date'],$_POST['search_date_to'], $_POST['branch']) as $invoice_data ){
                    foreach(InvoiceSub::find_all_invoice_id($invoice_data->id) as $invoice_sub_data){
                      echo $invoice_sub_data->code." , ";
                      $current_stock = $current_stock - 1;
                    }
                  }
                  echo "</td>";


                  // $StockRotate = StockRotateSales::find_by_dates($_POST['search_date'],$_POST['search_date_to'], $_POST['branch']);
                  // echo "<td style='text-align:center;'>".count($StockRotate)."</td>";

                  echo "<td style='text-align:center;'>";
                  $StockSale = StockRotateSales::find_by_dates_branch($_POST['search_date'] ,$_POST['search_date_to'], $_POST['branch']);
                  foreach ($StockSale as $StockSaleData) {
                    echo $StockSaleData->p_code." , ";
                    $current_stock = $current_stock - 1;
                  }
                  echo "</td>";

                  // $StockRotateUsage = StockRotateUsage::find_by_dates($_POST['search_date'],$_POST['search_date_to'], $_POST['branch']);
                  // echo "<td style='text-align:center;'>".count($StockRotateUsage)."</td>";

                  echo "<td style='text-align:center;'>";
                  $StockSale = StockRotateUsage::find_by_dates_branch($_POST['search_date'] ,$_POST['search_date_to'], $_POST['branch']);
                  foreach ($StockSale as $StockSaleData) {
                    echo $StockSaleData->p_code." , ";
                    $current_stock = $current_stock - 1;
                  }
                  echo "</td>";


                  // $StockWaveoff = StockWriteOffSales::find_by_dates($_POST['search_date'],$_POST['search_date_to'], $_POST['branch']);
                  // echo "<td style='text-align:center;'>".count($StockWaveoff)."</td>";

                  echo "<td style='text-align:center;'>";
                  $StockSale = StockWriteOffSales::find_by_dates_branch($_POST['search_date'] ,$_POST['search_date_to'], $_POST['branch']);
                  foreach ($StockSale as $StockSaleData) {
                    echo $StockSaleData->p_code." , ";
                    $current_stock = $current_stock - 1;
                  }
                  echo "</td>";


                  // $StockWaveoffUsage = StockWriteOffUsage::find_by_dates($_POST['search_date'],$_POST['search_date_to'], $_POST['branch']);
                  // echo "<td style='text-align:center;'>".count($StockWaveoffUsage)."</td>";

                  echo "<td style='text-align:center;'>";
                  $StockSale = StockWriteOffUsage::find_by_dates_branch($_POST['search_date'] ,$_POST['search_date_to'], $_POST['branch']);
                  foreach ($StockSale as $StockSaleData) {
                    echo $StockSaleData->p_code." , ";
                    $current_stock = $current_stock - 1;
                  }
                  echo "</td>";

                  echo "<td style='text-align:center;'>".$current_stock."</td>";
                  echo "</tr>";

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
