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
            <h2 id="title" style="font-weight:700;"> - BRANCH PRODUCT USED REPORT -
              <a href="branch_product_used_report.php" class="btn btn-info" role="button"> <i class="fa fa-list" aria-hidden="true"></i> Daily Report</a>
              <a href="branch_product_used_report_month.php" class="btn btn-info" role="button"> <i class="fa fa-list" aria-hidden="true"></i> Monthly Report</a>
            </h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <!-- form start -->

            <form class="form-inline" method="post" action="branch_product_used_report_month.php">


              <div class="form-group">
                <label for="pwd">Branch:</label><br/>
                <select class="form-control" name="branch_id">
                  <?php
                  
                  echo "<option value='0'>All Branches</option>";
                  foreach(Branch::find_all() as $branch){
                    $selected = '';
                    if(isset($_POST['branch_id']) && $_POST['branch_id'] == $branch->id){
                      $selected = "selected";
                    }
                    echo "<option value='".$branch->id."' $selected>".$branch->name."</option>";
                  }
                  ?>
                </select>
              </div>

              <div class="form-group">
                <label for="search_month">Month:</label><br/>
                <select name="search_month" class="form-control" id="search_month">
                  <option value="1" <?php if(isset($_POST['search_month']) && $_POST['search_month'] == 1) echo "selected"; ?>>January</option>
                  <option value="2" <?php if(isset($_POST['search_month']) && $_POST['search_month'] == 2) echo "selected"; ?>>February</option>
                  <option value="3" <?php if(isset($_POST['search_month']) && $_POST['search_month'] == 3) echo "selected"; ?>>March</option>
                  <option value="4" <?php if(isset($_POST['search_month']) && $_POST['search_month'] == 4) echo "selected"; ?>>April</option>
                  <option value="5" <?php if(isset($_POST['search_month']) && $_POST['search_month'] == 5) echo "selected"; ?>>May</option>
                  <option value="6" <?php if(isset($_POST['search_month']) && $_POST['search_month'] == 6) echo "selected"; ?>>June</option>
                  <option value="7" <?php if(isset($_POST['search_month']) && $_POST['search_month'] == 7) echo "selected"; ?>>July</option>
                  <option value="8" <?php if(isset($_POST['search_month']) && $_POST['search_month'] == 8) echo "selected"; ?>>August</option>
                  <option value="9" <?php if(isset($_POST['search_month']) && $_POST['search_month'] == 9) echo "selected"; ?>>Septmber</option>
                  <option value="10" <?php if(isset($_POST['search_month']) && $_POST['search_month'] == 10) echo "selected"; ?>>October</option>
                  <option value="11" <?php if(isset($_POST['search_month']) && $_POST['search_month'] == 11) echo "selected"; ?>>November</option>
                  <option value="12" <?php if(isset($_POST['search_month']) && $_POST['search_month'] == 12) echo "selected"; ?>>December</option>
                </select>
              </div>

              <div class="form-group">
                <label for="search_year">Year:</label><br/>
                <select name="search_year" class="form-control" id="search_year">
                  <?php
                    $start_year = 2010;
                    $end_year = date("Y");
                    for($i = $start_year; $i <= $end_year; $i++){ 
                        $selected = '';
                        if(isset($_POST['search_year']) && $_POST['search_year'] == $i){
                          $selected = "selected";
                        }
                        elseif($i == $end_year && !isset($_POST['search_year'])){
                          $selected = "selected";
                        }
                        echo "<option value='".$i."' $selected>".$i."</option>";
                    }                  
                  ?>
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

            <table class="table table-bordered" id="report_table">
              <thead>
                <tr>
                  <th>S/no.</th>
                  <th style='text-align:center;'>Stock Code</th>
                  <th style='text-align:center;'>Stock In</th>
                  <td style='text-align:center;'>S</td>
                  <td style='text-align:center;'>R</td>
                  <th style='text-align:center;'>Stock Rotate Sales</th>
                  <th style='text-align:center;'>Stock Rotate Usage</th>
                  <th style='text-align:center;'>Stock Write Off Sales</th>
                  <th style='text-align:center;'>Stock Write Off Usage</th>
                  <th style='text-align:center;'>Stock Transfer</th>
                  <th style='text-align:center;'>Stock Balance</th>
                </tr>

              </thead>
              <tbody>
                <?php
                $sno = 0;
                if(isset($_POST['search_month']) && isset($_POST['search_year']) && isset($_POST['branch_id'])){
                  $p_codes = Product :: get_all_product_code();
                  foreach($p_codes as $p_code){
                    $sno++;
                    echo "<tr>";
                    echo "<td style='text-align:center;'>".$sno."</td>
                          <td style='text-align:center;'>".$p_code->code."</td>";
                    
                    $StockProductUsage = StockProductUsage::find_stock_usage_by_code_month_branch( $_POST['search_month'],$_POST['search_year'],$_POST['branch_id'], $p_code->code );
                    echo "<td style='text-align:center;'>".$StockProductUsage."</td>";
                    
                    $s_quantity = StockProductUsage::find_s_usage_by_code_month_branch( $_POST['search_month'],$_POST['search_year'],$_POST['branch_id'], $p_code->code );
                    echo "<td style='text-align:center;'>".$s_quantity."</td>";

                    $r_quantity = StockProductUsage::find_R_usage_by_code_month_branch( $_POST['search_month'],$_POST['search_year'],$_POST['branch_id'], $p_code->code );
                    echo "<td style='text-align:center;'>".$r_quantity."</td>";

                    $StockRotate = StockRotateSales::find_stock_rotate_sale_by_code_month_branch($_POST['search_month'],$_POST['search_year'],$_POST['branch_id'], $p_code->code);
                    echo "<td style='text-align:center;'>".$StockRotate."</td>";

                    $StockRotateUsage = StockRotateUsage::find_stock_rotate_usage_by_code_month_branch($_POST['search_month'],$_POST['search_year'],$_POST['branch_id'], $p_code->code);
                    echo "<td style='text-align:center;'>".$StockRotateUsage."</td>";

                    $StockWaveoff = StockWriteOffSales::find_stock_waveoff_sale_by_month_code_branch($_POST['search_month'],$_POST['search_year'],$_POST['branch_id'], $p_code->code);
                    echo "<td style='text-align:center;'>".$StockWaveoff."</td>";

                    $StockWaveoffUsage = StockWriteOffUsage::find_stock_waveoff_usage_by_code_month_branch($_POST['search_month'],$_POST['search_year'],$_POST['branch_id'], $p_code->code);
                    echo "<td style='text-align:center;'>".$StockWaveoffUsage."</td>";

                    $StockTransferUsage = StockTransfer::find_stock_transfer_by_code_month_branch($_POST['search_month'],$_POST['search_year'],$_POST['branch_id'], $p_code->code);
                    echo "<td style='text-align:center;'>".$StockTransferUsage."</td>";

                    $stock_balance = $StockProductUsage - ($s_quantity+ $r_quantity + $StockRotate + $StockRotateUsage + $StockWaveoff + $StockWaveoffUsage + $StockTransferUsage);
                    echo "<td style='text-align:center;'>".$stock_balance."</td>";

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

<script>
  $(document).ready( function () {
    $('#report_table').DataTable({
      "lengthMenu": [[20, 50, 100, -1], [20, 50, 100, "All"]],
    });
  });
</script>
<!--/page content-->
<?php include 'common/bottom_content.php'; ?>
