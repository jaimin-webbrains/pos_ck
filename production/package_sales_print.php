<?php
require_once './../util/initialize.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Package Sales Report</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
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
</head>
<body>
  <div class="container-fluid">
    <hr/>
    <button class="btn btn-primary" onclick="exportTableToExcel('tblData')">Export Table Data To Excel File</button>
    <?php
    $input_type = 0;

    $branch_type = 0;
    if(isset($_POST['allbranches'])) {
      if($_POST['allbranches'] == "all") {
        $branch_type = 1;
      }
    }

    if($branch_type == 0) {
      // GET THE TABLE DATA
      $branch_obj = Branch::find_by_id($_POST['branch']);
    }

    if(isset($_POST['from_date']) && isset($_POST['to_date'])) {
      $from_date = $_POST['from_date'];
      $to_date = $_POST['to_date'];

      $date1_ts = strtotime($from_date);
      $date2_ts = strtotime($to_date);

      $from_date_val = $date1_ts;
      $to_date_val = $date2_ts;

      $input_type = 1;
    } else if(isset($_POST['year']) && isset($_POST['month']) && !isset($_POST['from_date']) && !isset($_POST['to_date'])) {
      // GET THE POST DATA
      $year = $_POST['year'];
      $month = $_POST['month'];

      $date1_ts = strtotime(date('Y-m-d', mktime(12, 0, 0, $month, 1, $year)));
      for($d=1; $d<=31; $d++)
      {
        $time = mktime(12, 0, 0, $month, $d, $year);
        if(date('m', $time) == $month)
          $to_date = date('Y-m-d', $time);
      }
      $date2_ts = strtotime($to_date);

      $from_date_val = $date1_ts;
      $to_date_val = $date2_ts;

      $input_type = 1;
    } else if(isset($_POST['year']) && !isset($_POST['month']) && !isset($_POST['from_date']) && !isset($_POST['to_date'])) {
      $year = $_POST['year'];

      $input_type = 2;
    }
    ?>
    <?php
    if($input_type == 1) {
    ?>
      <div class="row" style="padding-top:30px;">
        <!-- table starts -->
        <?php
        $cat_object = Package::find_all();
        
        $diff = $date2_ts - $date1_ts;
        $dateDiff = round($diff / 86400);
        ?>
        <table id="tblData" class="table table-bordered" style="font-size:10px;width:100%;">
          <thead>
            <tr>
              <th rowspan="2">Branch</th>
              <th>Name</th>
              <th>Code</th>
              <th colspan="<?php echo ($dateDiff+1); ?>" style="text-align:center;"></th>           
            </tr>
            <tr>
              <th><?php 
              if($branch_type == 0) echo $branch_obj->name; 
              else echo "All Branches";
              ?></th>
              <th><?php if($branch_type == 0) echo $branch_obj->code; ?></th>
              <th colspan="<?php echo ($dateDiff+1); ?>" style="text-align:center;">Package Sales Report</th>
            </tr>
            <tr>
              <th>S/No</th>
              <th>Product Code</th>
              <?php   
              $daily_cnt = array();       
              while ($date1_ts <= $date2_ts) {
                $datelabel = date('m/d', $date1_ts);
                echo "<th>" . $datelabel . "</th>";
                $date1_ts = strtotime('+1 days', $date1_ts);
                $daily_cnt[] = 0;
              }
              echo "<th style='text-align:center;'>Total</th>";
              ?>  
            </tr>
          </thead>
          <tbody>
            <!-- body start -->
            <?php
            if(isset($from_date_val) && isset($to_date_val) ) {
              $productcounter = 1;
              $total = 0;

              $previous_code = null;
              foreach(Package::find_all() as $cat_data){
                if($previous_code !== $cat_data->code) {
                  $total = 0;
                  $count = 0;
                  $countt = 0;

                  echo "<tr>";
                  echo "<td>$productcounter</td>";
                  echo "<td>". $cat_data->code . "</td>";

                  $previous_code = $cat_data->code;

                  $date1_ts = $from_date_val;
                  $date2_ts = $to_date_val;

                  $day_index = 0;
                  while ($date1_ts <= $date2_ts) {
                    $count = 0;
                    if($branch_type == 0)
                      $item_data = InvoiceSub::find_by_type_code(3, $cat_data->code, date('Y-m-d', $date1_ts), $_POST['branch']);
                    else
                      $item_data = InvoiceSub::find_by_type_code_without_branch(3, $cat_data->code, date('Y-m-d', $date1_ts));
                    foreach($item_data as $live_count) {
                      $count = $count + $live_count->qty;
                      // $countt = $countt + ($live_count->qty * $live_count->unit_price);
                    }

                    echo "<td>" . $count . "</td>";
                    $date1_ts = strtotime('+1 days', $date1_ts);
                    $total = $total + $count;
                    $daily_cnt[$day_index] += $count;
                    $day_index++;
                  }

                  echo "<td>".$total."</td>";
                  echo "</tr>";
                  $date1_ts = strtotime('+1 days', $date1_ts);
                  $productcounter = $productcounter + 1;
                }
              }

              $total = 0;
              $count = 0;
              $countt = 0;

              echo "<tr>";
              echo "<td colspan='2'>Total</td>";

              $date1_ts = $from_date_val;
              $date2_ts = $to_date_val;

              $day_index = 0;
              while ($date1_ts <= $date2_ts) {
                echo "<td>" . $daily_cnt[$day_index] . "</td>";
                $date1_ts = strtotime('+1 days', $date1_ts);
                $total = $total + $daily_cnt[$day_index];
                $day_index++;
              }

              echo "<td>".$total."</td>";
            }
            ?>
            <!-- body ends -->
          </tbody>
        </table>
        <!-- table ends -->
      </div>
    <?php
    }
    ?> 
    <?php
    if($input_type == 2) {
    ?>
      <div class="row" style="padding-top:30px;">
        <!-- table starts -->
        <?php
        $cat_object = Package::find_all();

        $month = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"); 
        
        ?>
        <table id="tblData" class="table table-bordered" style="font-size:10px;width:100%;">
          <thead>
            <tr>
              <th rowspan="2">Branch</th>
              <th>Name</th>
              <th>Code</th>
              <th colspan="13" style="text-align:center;">Package Sales Report</th>           
            </tr>
            <tr>
            <th><?php 
              if($branch_type == 0) echo $branch_obj->name; 
              else echo "All Branches";
              ?></th>
              <th><?php if($branch_type == 0) echo $branch_obj->code; ?></th>
              <th colspan="13" style="text-align:center;"></th>
            </tr>
            <tr>
              <th>S/No</th>
              <th>Product Code</th>
              <?php   
                  
              for($i=0; $i<12; $i++) {
                print '<th style="text-align: center;">'.$month[$i].'</th>';
              }
              echo "<th style='text-align:center;'>Total</th>";
              ?>  
            </tr>
          </thead>
          <tbody>
            <!-- body start -->
            <?php
            if(isset($_POST['year'])) {
              $year = $_POST['year'];

              $productcounter = 1;
              $monthly_cnt = array(); 
              for($i=0; $i<12; $i++) {
                $monthly_cnt[] = 0;
              }  

              $previous_code = null;
              foreach(Package::find_all() as $cat_data) {
                if($previous_code !== $cat_data->code) {
                  $total = 0;
                  $count = 0;
                  $countt = 0;

                  echo "<tr>";
                  echo "<td>$productcounter</td>";
                  echo "<td>". $cat_data->code . "</td>";

                  $previous_code = $cat_data->code;

                  for($i=0; $i<12; $i++) {
                    $count = 0;

                    $date1_ts = mktime(0, 0, 0, $i+1, 1, $year);                  
                    $strdate1 = date('Y-m-d H:i:s', $date1_ts);

                    if($i !== 11)
                      $date2_ts = mktime(0, 0, 0, $i+2, 1, $year);
                    else
                      $date2_ts = mktime(0, 0, 0, 1, 1, $year+1);
                    $strdate2 = date('Y-m-d H:i:s', $date2_ts);
                    
                    if($branch_type == 0)
                      $item_data = InvoiceSub::find_by_type_branch_code_type_date_range(3, $cat_data->code, $_POST['branch'], $strdate1, $strdate2);
                    else 
                      $item_data = InvoiceSub::find_by_type_branch_code_type_date_range_without_branch(3, $cat_data->code, $strdate1, $strdate2);
                    foreach($item_data as $live_count) {
                      $count = $count + $live_count->qty;
                      // $countt = $countt + ($live_count->qty * $live_count->unit_price);
                    }

                    echo "<td>" . $count . "</td>";
                    $total = $total + $count;
                    $monthly_cnt[$i] += $count;
                  }

                  echo "<td>".$total."</td>";
                  echo "</tr>";
                  $productcounter = $productcounter + 1;
                }
              }

              $total = 0;
              $count = 0;
              $countt = 0;

              echo "<tr>";
              echo "<td colspan='2'>Total</td>";

              for($i=0; $i<12; $i++) {
                echo "<td>" . $monthly_cnt[$i] . "</td>";
                $total += $monthly_cnt[$i];
              }
              echo "<td>".$total."</td>";
            }
            ?>
            <!-- body ends -->
          </tbody>
        </table>
        <!-- table ends -->
      </div>
    <?php
    }
    ?> 
  </div>
</body>
</html>
