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

            <form class="form-inline" method="post" action="overview_report_month_branch.php">


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
                if( isset($_POST['branch']) && isset($_POST['search_month']) ){

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



                  echo "<td style='text-align:center;'>";
                  $StockSale = StockProductSales::find_by_date_branch($search_date, $_POST['branch']);
                  foreach ($StockSale as $StockSaleData) {
                    echo $StockSaleData->p_code." , ";
                    $current_stock = $current_stock + 1;
                  }

                  echo "</td>";

                  echo "<td style='text-align:center;'>";
                  $StockUsed = StockProductUsage::find_by_date_branch($search_date, $_POST['branch']);
                  foreach ($StockUsed as $StockUsedData) {
                    echo $StockSaleData->p_code." , ";
                    $current_stock = $current_stock + 1;
                  }
                  echo "</td>";

                  echo "<td style='text-align:center;'>";
                  foreach( Invoice::find_by_branch_date($search_date, $_POST['branch']) as $invoice_data ){
                    foreach(InvoiceSub::find_all_invoice_id($invoice_data->id) as $invoice_sub_data){
                      echo $invoice_sub_data->code." , ";
                      $current_stock = $current_stock - 1;
                    }
                  }
                  echo "</td>";

                  echo "<td style='text-align:center;'>";
                  $StockSale = StockRotateSales::find_by_date_branch($search_date, $_POST['branch']);
                  foreach ($StockSale as $StockSaleData) {
                    echo $StockSaleData->p_code." , ";
                    $current_stock = $current_stock - 1;
                  }
                  echo "</td>";

                  echo "<td style='text-align:center;'>";
                  $StockSale = StockRotateUsage::find_by_date_branch($search_date, $_POST['branch']);
                  foreach ($StockSale as $StockSaleData) {
                    echo $StockSaleData->p_code." , ";
                    $current_stock = $current_stock - 1;
                  }
                  echo "</td>";

                  echo "<td style='text-align:center;'>";
                  $StockSale = StockWriteOffSales::find_by_date_branch($search_date, $_POST['branch']);
                  foreach ($StockSale as $StockSaleData) {
                    echo $StockSaleData->p_code." , ";
                    $current_stock = $current_stock - 1;
                  }
                  echo "</td>";

                  echo "<td style='text-align:center;'>";
                  $StockSale = StockWriteOffUsage::find_by_date_branch($search_date, $_POST['branch']);
                  foreach ($StockSale as $StockSaleData) {
                    echo $StockSaleData->p_code." , ";
                    $current_stock = $current_stock - 1;
                  }
                  echo "</td>";

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
