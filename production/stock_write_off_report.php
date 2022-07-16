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
            <h2 id="title" style="font-weight:700;"> - STOCK WRITE OFF REPORT - (Date)</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <!-- form start -->
            <form class="form-inline" method="post" action="stock_write_off_report.php">
              <div class="form-group" style="margin-right:30px;">
                <div>
                  <label for="contact_email">All Branches</label>  
                </div>
                <div>
                  <input type="radio" name="allbranches" id="allbranches_all" value="all" checked/>
                  <label for="allbranches_all">Yes</label>
                  <input type="radio" name="allbranches" id="allbranches_one" value="one" style="margin-left:30px;"/>
                  <label for="allbranches_one">No</label>
                </div>
              </div>

              <div class="form-group" style="margin-right:30px;">
                <div>
                  <label for="search_branch">Branch</label>  
                </div>
                <div>
                  <select class="form-control" name="branch_id" id="branch_id">
                  <?php
                    foreach(Branch::find_all() as $branch){
                      echo "<option value='".$branch->id."' $selected>".$branch->name."</option>";
                    }
                  ?>
                </select>
                </div>
              </div>

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
            <h2 id="title" style="font-weight:700;"> - STOCK WRITE OFF REPORT - (Month)</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <form class="form-inline" method="post" action="stock_write_off_report.php">
              <div class="form-group" style="margin-right:30px;">
                <div>
                  <label for="contact_email">All Branches</label>  
                </div>
                <div>
                  <input type="radio" name="allbranches" id="allbranches_all_2" value="all" checked/>
                  <label for="allbranches_all_2">Yes</label>
                  <input type="radio" name="allbranches" id="allbranches_one_2" value="one" style="margin-left:30px;"/>
                  <label for="allbranches_one_2">No</label>
                </div>
              </div>

              <div class="form-group" style="margin-right:30px;">
                <div>
                  <label for="search_branch">Branch</label>  
                </div>
                <div>
                  <select class="form-control" name="branch_id" id="branch_id_2">
                  <?php
                    foreach(Branch::find_all() as $branch){
                      echo "<option value='".$branch->id."' $selected>".$branch->name."</option>";
                    }
                  ?>
                </select>
                </div>
              </div>
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
            <h2 id="title" style="font-weight:700;"> - STOCK WRITE OFF REPORT - (Year)</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <form class="form-inline" method="post" action="stock_write_off_report.php">
              <div class="form-group" style="margin-right:30px;">
                <div>
                  <label for="contact_email">All Branches</label>  
                </div>
                <div>
                  <input type="radio" name="allbranches" id="allbranches_all_3" value="all" checked/>
                  <label for="allbranches_all_3">Yes</label>
                  <input type="radio" name="allbranches" id="allbranches_one_3" value="one" style="margin-left:30px;"/>
                  <label for="allbranches_one_3">No</label>
                </div>
              </div>

              <div class="form-group" style="margin-right:30px;">
                <div>
                  <label for="search_branch">Branch</label>  
                </div>
                <div>
                  <select class="form-control" name="branch_id" id="branch_id_3">
                  <?php
                    foreach(Branch::find_all() as $branch){
                      echo "<option value='".$branch->id."' $selected>".$branch->name."</option>";
                    }
                  ?>
                </select>
                </div>
              </div>
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
              //report title desc.
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
                  <th style='text-align:center;'>Product Code</th>
                  <th style='text-align:center;' <?php echo $colspan;?>>Stock Write Off Sale</th>
                  <th style='text-align:center;' <?php echo $colspan;?>>Stock Write Off Usage</th>
                </tr>
                <tr>
                  <th></th>
                  <th></th>
                <?php
                //Header rows
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
                            <th>Dec</th>
                            ";
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
                </tr>
                
              </thead>
              <tbody>
               
                <?php
                //report rows
                $sno = 0;
                $stock_sale_total_qty = 0;
                $stock_usage_total_qty = 0;
                if(isset($_POST['search_year']) && !isset($_POST['search_month'])){
                  $branch_id = NULL;
                  if(isset($_POST['branch_id'])){
                    $branch_id = $_POST['branch_id'];
                  }
                  $p_codes = Product :: get_all_product_code();
                  foreach($p_codes as $p_code){
                    $sno++;
                    echo "<tr>";
                    echo "<td style='text-align:center;'>".$sno."</td>
                          <td style='text-align:center;'>".$p_code->code."</td>";
                  
                    $StockWriteOffSales = Reports::get_write_off_quantity_by_branch_year_month_wise('StockWriteOffSales', $_POST['search_year'], $branch_id, $p_code->code);
                    for($month=1; $month<=12; $month++){
                      echo "<td style='text-align:center;'>".$StockWriteOffSales[$month]."</td>";
                      $stock_sale_total_qty += $StockWriteOffSales[$month] ;
                    }

                    $StockWriteOffUsage = Reports::get_write_off_quantity_by_branch_year_month_wise('StockWriteOffUsage', $_POST['search_year'], $branch_id, $p_code->code);
                    for($month=1; $month<=12; $month++){
                      echo "<td style='text-align:center;'>".$StockWriteOffUsage[$month]."</td>";
                      $stock_sale_total_qty += $StockWriteOffUsage[$month] ;
                    }

                    echo "</tr>";
                  }
                }

                if(isset($_POST['search_year']) && isset($_POST['search_month'])){
                  $branch_id = NULL;
                  if(isset($_POST['branch_id'])){
                    $branch_id = $_POST['branch_id'];
                  }
                  $p_codes = Product :: get_all_product_code();
                  foreach($p_codes as $p_code){
                    $sno++;
                    echo "<tr>";
                    echo "<td style='text-align:center;'>".$sno."</td>
                          <td style='text-align:center;'>".$p_code->code."</td>";

                    $StockWriteOffSales = Reports::get_write_off_quantity_by_branch_year_month_day_wise('StockWriteOffSales', $_POST['search_month'], $_POST['search_year'], $branch_id, $p_code->code);
                    for($day = 1; $day <= $days_in_month; $day++){
                      echo "<td style='text-align:center;'>".$StockWriteOffSales[$day]."</td>";
                    }

                    $StockWriteOffUsage = Reports::get_write_off_quantity_by_branch_year_month_day_wise('StockWriteOffUsage', $_POST['search_month'], $_POST['search_year'], $branch_id, $p_code->code);
                    for($day = 1; $day <= $days_in_month; $day++){
                      echo "<td style='text-align:center;'>".$StockWriteOffUsage[$day]."</td>";
                    }

                    echo "</tr>";
                  }
                }

                if(isset($_POST['from_date']) && isset($_POST['to_date']) && $error_count == 0){
                  $branch_id = NULL;
                  if(isset($_POST['branch_id'])){
                    $branch_id = $_POST['branch_id'];
                  }
                  $p_codes = Product :: get_all_product_code();
                  foreach($p_codes as $p_code){
                    $sno++;
                    echo "<tr>";
                    echo "<td style='text-align:center;'>".$sno."</td>
                          <td style='text-align:center;'>".$p_code->code."</td>";

                    $StockWriteOffSales = Reports::get_write_off_quantity_by_branch_day_wise('StockWriteOffSales', $_POST['from_date'], $_POST['to_date'], $branch_id,$p_code->code);
                    foreach($StockWriteOffSales as $key=>$value){
                      echo "<td style='text-align:center;'>".$value."</td>";
                    }

                    $StockWriteOffUsage = Reports::get_write_off_quantity_by_branch_day_wise('StockWriteOffUsage', $_POST['from_date'], $_POST['to_date'], $branch_id,$p_code->code);
                    foreach($StockWriteOffUsage as $key=>$value){
                      echo "<td style='text-align:center;'>".$value."</td>";
                    }

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
    $('#branch_id').attr("disabled", "true");
    $('#branch_id_2').attr("disabled", "true");
    $('#branch_id_3').attr("disabled", "true");

    $("#allbranches_all").click(() => {
      $('#branch_id').attr("disabled", "true");
    });
    $("#allbranches_one").click(() => {
      $('#branch_id').removeAttr("disabled");
    });

    $("#allbranches_all_2").click(() => {
      $('#branch_id_2').attr("disabled", "true");
    });
    $("#allbranches_one_2").click(() => {
      $('#branch_id_2').removeAttr("disabled");
    });

    $("#allbranches_all_3").click(() => {
      $('#branch_id_3').attr("disabled", "true");
    });
    $("#allbranches_one_3").click(() => {
      $('#branch_id_3').removeAttr("disabled");
    });

    $('#report_table').DataTable({
      "lengthMenu": [[50, 100, -1], [50, 100, "All"]],
    });

  });
</script>
<!--/page content-->
<?php include 'common/bottom_content.php'; ?>
