<?php
require_once './../util/initialize.php';
include 'common/upper_content.php';
?>

<!--page content-->
<div class="right_col" role="main">
  <div class="">
    <?php Functions::output_result(); ?>
    <div class="row">
      <!-- FIRST COLUMN -->
      <?php
        $error_count = 0;
        if(isset($_POST['from_date']) && isset($_POST['to_date'])){
          $diff=date_diff(date_create($_POST['from_date']),date_create($_POST['to_date']));
          if($diff->format("%a") > 15){
            $error = "Please select less than 15 days";
            $error_count = 1;
          }
        }    
      ?>
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2 id="title" style="font-weight:700;"> - WAREHOUSE OVERVIEW REPORT - (Date)</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <!-- form start -->
            <form class="form-inline" method="post" action="warehouse_overview_report.php">
              <div class="form-group">
                <label for="from_date">From Date:</label><br/>
                <input type="date" class="form-control" name="from_date" required>
              </div>
              <div class="form-group">
                <label for="to_date">To Date:</label><br/>
                <input type="date" class="form-control" name="to_date" required>
              </div>
              <div class="form-group">
                <br/>
                <button type="submit" class="btn btn-primary">FIND</button>
              </div>
              <div class="form-group">
                
              </div>
              
            </form>
            <p style="color:red; margin-top:10px"><?php if(isset($error)) echo $error;?></p>
            
            <!-- form ends -->
          </div>
        </div>
      </div>
      <!-- END FIRST COLUMN -->
            
      <!-- SECOND COLUMN -->
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2 id="title" style="font-weight:700;"> - WAREHOUSE OVERVIEW REPORT - (Month)</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <form class="form-inline" method="post" action="warehouse_overview_report.php">
              
              <div class="form-group">
                <label for="search_year">Year:</label><br/>
                <select name="search_year" class="form-control" id="search_year">
                  <?php
                    $start_year = 2015;
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
                <label>MONTH:</label><br/>
                <select class="form-control" name="search_month">
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
      <!-- END SECOND COLUMN -->

      <!-- THIRD COLUMN -->
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2 id="title" style="font-weight:700;"> - WAREHOUSE OVERVIEW REPORT - (Year)</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <form class="form-inline" method="post" action="warehouse_overview_report.php">
            
              <div class="form-group">
                <label for="search_year">Year:</label><br/>
                <select name="search_year" class="form-control" id="search_year">
                  <?php
                    $start_year = 2015;
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
      <!-- END THIRD COLUMN -->

      <!-- REPORT COLUMN -->
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <?php
              $report_desc = '';
              if(isset($_POST['search_year']) && !isset($_POST['search_month'])){
                $report_desc = '(Year - '.$_POST['search_year'].")";
              }
              if(isset($_POST['search_year']) && isset($_POST['search_month'])){ 
                $month_name = date("F", mktime(0, 0, 0, $_POST['search_month']+1, 0));
                $report_desc = "(".$month_name."-".$_POST['search_year'].")";
              }   
              if(isset($_POST['from_date']) && isset($_POST['to_date']) && $error_count == 0){
                $diff=date_diff(date_create($_POST['from_date']),date_create($_POST['to_date']));
                if($diff->format("%a") > 15){
                  $error = "Select less thgan 15 days";
                }
                $report_desc = "(".$_POST['from_date']." to ".$_POST['to_date'].")";
              }      
            ?>
            <h2 id="title" style="font-weight:700;">Report <?php echo $report_desc?></h2>
            <button class="btn btn-primary" style="float:right" onclick="exportTableToExcel('report_table')">Export Table</button>
            <div class="clearfix"></div>
          </div>
          <div class="x_content" style="overflow-x:auto;">
            <!-- table start -->
            
            <table class="table table-bordered" id="report_table">
              <thead>
                <?php
                $colspan = '';
                $days_in_month = 0;
                  if(isset($_POST['search_year']) && !isset($_POST['search_month'])){
                    $colspan = 'colspan="12"';
                  }
                  if(isset($_POST['search_year']) && isset($_POST['search_month'])){ 
                    $days_in_month=cal_days_in_month(CAL_GREGORIAN,$_POST['search_month'],$_POST['search_year']); 
                    $colspan = 'colspan="'.$days_in_month.'"'; 
                  }   
                  if(isset($_POST['from_date']) && isset($_POST['to_date'])){
                    $diff=date_diff(date_create($_POST['from_date']),date_create($_POST['to_date']));
                    $difference = $diff->format("%a");
                    $colspan = 'colspan="'.$difference.'"'; 
                  }                 
                ?>
                <tr>
                  <th>S/no.</th>
                  <th style='text-align:center;'>Stock Code</th>
                  <th style='text-align:center;'>Stock In</th>
                  <th style='text-align:center;' <?php echo $colspan;?>>Stock Product Sale</th>
                  <th style='text-align:center;' <?php echo $colspan;?>>Stock Product Usage</th>
                  <th style='text-align:center;'>Stock Rotate Sales</th>
                  <th style='text-align:center;'>Stock Rotate Usage</th>
                  <th style='text-align:center;'>Stock WriteOff Sales</th>
                  <th style='text-align:center;'>Stock WriteOff Usage</th>
                  <th style='text-align:center;'>Stock Transfer</th>
                  <th style='text-align:center;'>Stock Balance</th>
                </tr>
                <tr>
                  <th></th>
                  <th></th>
                  <th></th>
                <?php
                  if(isset($_POST['search_year']) && !isset($_POST['search_month'])){
                    echo " <th>Jan</th>
                            <th>Feb</th>
                            <th>Mar</th>
                            <th>Apr</th>
                            <th>May</th>
                            <th>June</th>
                            <th>July</th>
                            <th>Aug</th>
                            <th>Sept</th>
                            <th>Oct</th>
                            <th>Nov</th>
                            <th>Dec</th>
                            <th>Jan</th>
                            <th>Feb</th>
                            <th>Mar</th>
                            <th>Apr</th>
                            <th>May</th>
                            <th>June</th>
                            <th>July</th>
                            <th>Aug</th>
                            <th>Sept</th>
                            <th>Oct</th>
                            <th>Nov</th>
                            <th>Dec</th>";
                  }

                  if(isset($_POST['search_year']) && isset($_POST['search_month'])){ 
                    $days_in_month=cal_days_in_month(CAL_GREGORIAN,$_POST['search_month'],$_POST['search_year']);  
                    for($i=1; $i<=$days_in_month; $i++){
                      echo "<th>".$i."/".$_POST['search_month']."</th>";
                    }
                    for($i=1; $i<=$days_in_month; $i++){
                      echo "<th>".$i."/".$_POST['search_month']."</th>";
                    } 
                  }

                  if(isset($_POST['from_date']) && isset($_POST['to_date']) && $error_count == 0){ 
                    $period = new DatePeriod(
                        new DateTime($_POST['from_date']),
                        new DateInterval('P1D'),
                        new DateTime($_POST['to_date'])
                    );

                    foreach ($period as $key => $value) {
                      echo "<th>".$value->format('d/m')."</th>";
                    }
                    foreach ($period as $key => $value) {
                      echo "<th>".$value->format('d/m')."</th>";
                    }
                  }             
                ?>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                </tr>
                
              </thead>
              <tbody>
               
                <?php
                $sno = 0;
                $stock_sale_total_qty = 0;
                $stock_usage_total_qty = 0;
                if(isset($_POST['search_year']) && !isset($_POST['search_month'])){
                  $p_codes = Product :: get_all_product_code();
                  foreach($p_codes as $p_code){
                    $sno++;
                    echo "<tr>";
                    echo "<td style='text-align:center;'>".$sno."</td>
                          <td style='text-align:center;'>".$p_code->code."</td>";
                    
                    $StockReceive = Reports::get_quantity_by_year('StockReceive', $_POST['search_year'], $p_code->code );
                    echo "<td style='text-align:center;'>".$StockReceive."</td>";

                    $StockSale = Reports::get_quantity_by_year_month_wise('StockProductSales', $_POST['search_year'], $p_code->code);
                    for($month=1; $month<=12; $month++){
                      echo "<td style='text-align:center;'>".$StockSale[$month]."</td>";
                      $stock_sale_total_qty += $StockSale[$month] ;
                    }

                    $StockUsed = Reports::get_quantity_by_year_month_wise('StockProductUsage', $_POST['search_year'], $p_code->code);
                    for($month=1; $month<=12; $month++){
                      echo "<td style='text-align:center;'>".$StockUsed[$month]."</td>";
                      $stock_usage_total_qty += $StockUsed[$month] ;
                    }
 
                    $StockRotate = Reports::get_quantity_by_year('StockRotateSales', $_POST['search_year'], $p_code->code);
                    echo "<td style='text-align:center;'>".$StockRotate."</td>";

                    $StockRotateUsage = Reports::get_quantity_by_year('StockRotateUsage', $_POST['search_year'], $p_code->code);
                    echo "<td style='text-align:center;'>".$StockRotateUsage."</td>";

                    $StockWaveoff = Reports::get_writeOff_quantity_by_year('StockWriteOffSales', $_POST['search_year'], $p_code->code);
                    echo "<td style='text-align:center;'>".$StockWaveoff."</td>";

                    $StockWaveoffUsage = Reports::get_writeOff_quantity_by_year('StockWriteOffUsage', $_POST['search_year'], $p_code->code);
                    echo "<td style='text-align:center;'>".$StockWaveoffUsage."</td>";

                    $StockTransferUsage = Reports::get_stock_transfer_quantity_by_year('StockTransfer', $_POST['search_year'], $p_code->code);
                    echo "<td style='text-align:center;'>".$StockTransferUsage."</td>";

                    $stock_balance = $StockReceive -( $stock_sale_total_qty + $stock_usage_total_qty + $StockRotate + $StockRotateUsage + $StockWaveoff + $StockWaveoffUsage + $StockTransferUsage);
                    echo "<td style='text-align:center;'>".$stock_balance."</td>";

                    echo "</tr>";
                  }
                }

                if(isset($_POST['search_year']) && isset($_POST['search_month'])){
                  $p_codes = Product :: get_all_product_code();
                  foreach($p_codes as $p_code){
                    $sno++;
                    echo "<tr>";
                    echo "<td style='text-align:center;'>".$sno."</td>
                          <td style='text-align:center;'>".$p_code->code."</td>";
                    
                    $StockReceive = Reports::get_quantity_by_month_year('StockReceive',$_POST['search_month'], $_POST['search_year'], $p_code->code );
                    echo "<td style='text-align:center;'>".$StockReceive."</td>";

                    $StockSale = Reports::get_quantity_by_year_month_day_wise('StockProductSales', $_POST['search_month'], $_POST['search_year'], $p_code->code);
                    for($day = 1; $day <= $days_in_month; $day++){
                      echo "<td style='text-align:center;'>".$StockSale[$day]."</td>";
                      $stock_sale_total_qty += $StockSale[$day] ;
                    }

                    $StockUsed = Reports::get_quantity_by_year_month_day_wise('StockProductUsage', $_POST['search_month'], $_POST['search_year'], $p_code->code);
                    for($day = 1; $day <= $days_in_month; $day++){
                      echo "<td style='text-align:center;'>".$StockUsed[$day]."</td>";
                      $stock_usage_total_qty += $StockUsed[$day] ;
                    }
 
                    $StockRotate = Reports::get_quantity_by_month_year('StockRotateSales', $_POST['search_month'], $_POST['search_year'], $p_code->code);
                    echo "<td style='text-align:center;'>".$StockRotate."</td>";

                    $StockRotateUsage = Reports::get_quantity_by_month_year('StockRotateUsage', $_POST['search_month'], $_POST['search_year'], $p_code->code);
                    echo "<td style='text-align:center;'>".$StockRotateUsage."</td>";

                    $StockWaveoff = Reports::get_writeOff_quantity_by_month_year('StockWriteOffSales', $_POST['search_month'], $_POST['search_year'], $p_code->code);
                    echo "<td style='text-align:center;'>".$StockWaveoff."</td>";

                    $StockWaveoffUsage = Reports::get_writeOff_quantity_by_month_year('StockWriteOffUsage', $_POST['search_month'], $_POST['search_year'], $p_code->code);
                    echo "<td style='text-align:center;'>".$StockWaveoffUsage."</td>";

                    $StockTransferUsage = Reports::get_stock_transfer_quantity_by_month_year('StockTransfer', $_POST['search_month'], $_POST['search_year'], $p_code->code);
                    echo "<td style='text-align:center;'>".$StockTransferUsage."</td>";

                    $stock_balance = $StockReceive -( $stock_sale_total_qty + $stock_usage_total_qty + $StockRotate + $StockRotateUsage + $StockWaveoff + $StockWaveoffUsage + $StockTransferUsage);
                    echo "<td style='text-align:center;'>".$stock_balance."</td>";

                    echo "</tr>";
                  }
                }

                if(isset($_POST['from_date']) && isset($_POST['to_date']) && $error_count == 0){
                  
                  $p_codes = Product :: get_all_product_code();
                  foreach($p_codes as $p_code){
                    $sno++;
                    echo "<tr>";
                    echo "<td style='text-align:center;'>".$sno."</td>
                          <td style='text-align:center;'>".$p_code->code."</td>";
                    
                    $StockReceive = Reports::get_quantity_by_day('StockReceive',$_POST['from_date'], $_POST['to_date'], $p_code->code );
                    echo "<td style='text-align:center;'>".$StockReceive."</td>";

                    $StockSale = Reports::get_quantity_day_wise('StockProductSales', $_POST['from_date'], $_POST['to_date'], $p_code->code);
                    foreach($StockSale as $key=>$value){
                      echo "<td style='text-align:center;'>".$value."</td>";
                      $stock_sale_total_qty += $value ;
                    }

                    $StockUsed = Reports::get_quantity_day_wise('StockProductUsage', $_POST['from_date'], $_POST['to_date'], $p_code->code);
                    foreach($StockUsed as $key=>$value){
                      echo "<td style='text-align:center;'>".$value."</td>";
                      $stock_usage_total_qty += $value ;
                    }

                    $StockRotate = Reports::get_quantity_by_day('StockRotateSales', $_POST['from_date'], $_POST['to_date'], $p_code->code);
                    echo "<td style='text-align:center;'>".$StockRotate."</td>";

                    $StockRotateUsage = Reports::get_quantity_by_day('StockRotateUsage', $_POST['from_date'], $_POST['to_date'], $p_code->code);
                    echo "<td style='text-align:center;'>".$StockRotateUsage."</td>";

                    $StockWaveoff = Reports::get_writeOff_quantity_by_day('StockWriteOffSales', $_POST['from_date'], $_POST['to_date'], $p_code->code);
                    echo "<td style='text-align:center;'>".$StockWaveoff."</td>";

                    $StockWaveoffUsage = Reports::get_writeOff_quantity_by_day('StockWriteOffUsage', $_POST['from_date'], $_POST['to_date'], $p_code->code);
                    echo "<td style='text-align:center;'>".$StockWaveoffUsage."</td>";

                    $StockTransferUsage = Reports::get_stock_transfer_quantity_by_day('StockTransfer', $_POST['from_date'], $_POST['to_date'], $p_code->code);
                    echo "<td style='text-align:center;'>".$StockTransferUsage."</td>";

                    $stock_balance = $StockReceive -( $stock_sale_total_qty + $stock_usage_total_qty + $StockRotate + $StockRotateUsage + $StockWaveoff + $StockWaveoffUsage + $StockTransferUsage);
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
      <!-- END REPORT COLUMN -->

    </div>
  </div>
</div>

<script type="text/javascript">
  function exportTableToExcel(tableID, filename = '') {
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';
    // Create download link element
    downloadLink = document.createElement("a");
    document.body.appendChild(downloadLink);
    if(navigator.msSaveOrOpenBlob){
      var blob = new Blob(['\ufeff', tableHTML], {
        type: dataType
      });
      navigator.msSaveOrOpenBlob( blob, filename);
    }else{
      // Create a link to the file
      downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

      // Setting the file name
      downloadLink.download = filename;

      //triggering the function
      downloadLink.click();
    }
  }
</script>
<script>
  $(document).ready( function () {

    $('#report_table').DataTable({
      "lengthMenu": [[50, 100, -1], [50, 100, "All"]],
    });

  });
</script>
<!--/page content-->
<?php include 'common/bottom_content.php'; ?>
