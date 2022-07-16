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

            <form class="form-inline" method="post" action="overview_report_year_branch.php">

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
                if(isset($_POST['search_year']) && isset($_POST['branch']) ){
                  $current_stock = 0;
                  $month = 1;
                  while( $month <= 12 ){
                    echo "<tr>";
                    $monthNum  = $month;
                    $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                    echo "<td>".$_POST['search_year']." - ".$dateObj->format('F')."</td>";



                    echo "<td style='text-align:center;'>";
                    $StockSale = StockProductSales::find_by_month_branch($month, $_POST['branch']);
                    foreach ($StockSale as $StockSaleData) {
                      echo $StockSaleData->p_code." , ";
                      $current_stock = $current_stock + 1;
                    }
                    echo "</td>";

                    echo "<td style='text-align:center;'>";
                    $StockUsed = StockProductUsage::find_by_month_branch($month, $_POST['branch']);
                    foreach ($StockUsed as $StockSaleData) {
                      echo $StockSaleData->p_code." , ";
                      $current_stock = $current_stock + 1;
                    }
                    echo "</td>";

                    echo "<td style='text-align:center;'>";
                    foreach( Invoice::find_by_branch_month($month, $_POST['branch']) as $invoice_data ){
                      foreach(InvoiceSub::find_all_invoice_id($invoice_data->id) as $invoice_sub_data){
                        echo $invoice_sub_data->code." , ";
                        $current_stock = $current_stock - 1;
                      }
                    }
                    echo "</td>";

                    echo "<td style='text-align:center;'>";
                    $StockRotate = StockRotateSales::find_by_month_branch($month, $_POST['branch']);
                    foreach ($StockRotate as $StockSaleData) {
                      echo $StockSaleData->p_code." , ";
                      $current_stock = $current_stock - 1;
                    }
                    echo "</td>";

                    echo "<td style='text-align:center;'>";
                    $StockRotateUsage = StockRotateUsage::find_by_month_branch($month, $_POST['branch']);
                    foreach ($StockRotateUsage as $StockSaleData) {
                      echo $StockSaleData->p_code." , ";
                      $current_stock = $current_stock - 1;
                    }
                    echo "</td>";

                    echo "<td style='text-align:center;'>";
                    $StockWaveoff = StockWriteOffSales::find_by_month_branch($month, $_POST['branch']);
                    foreach ($StockWaveoff as $StockSaleData) {
                      echo $StockSaleData->p_code." , ";
                      $current_stock = $current_stock - 1;
                    }
                    echo "</td>";

                    echo "<td style='text-align:center;'>";
                    $StockWaveoffUsage = StockWriteOffUsage::find_by_month_branch($month, $_POST['branch']);
                    foreach ($StockWaveoffUsage as $StockSaleData) {
                      echo $StockSaleData->p_code." , ";
                      $current_stock = $current_stock - 1;
                    }
                    echo "</td>";

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
