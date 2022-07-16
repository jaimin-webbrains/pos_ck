<?php
require_once './../util/initialize.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Service Code Report</title>
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
    $branch_type = 0; // only one branch
    $date_type = 0; // from date and to date

    if(isset($_POST['allbranches'])) {
      if($_POST['allbranches'] == "all") {
        $branch_type = 1;
      }
    }

    if($branch_type == 0) {
      $branch_id = $_POST['branch'];
      $branch_obj = Branch::find_by_id($_POST['branch']);
    }

    if(isset($_POST['year']) && !isset($_POST['month']) && !isset($_POST['from_date']) && !isset($_POST['to_date'])) {
      $date_type = 1;
    }

    if(isset($_POST['from_date']) && isset($_POST['to_date'])) {
      $from_date = $_POST['from_date'];
      $to_date = $_POST['to_date'];

      $date1_ts = strtotime($from_date);
      $date2_ts = strtotime($to_date);

      $from_date_val = $date1_ts;
      $to_date_val = $date2_ts;
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

    } else if(isset($_POST['year']) && !isset($_POST['month']) && !isset($_POST['from_date']) && !isset($_POST['to_date'])) {
      $year = $_POST['year'];
    }
    ?>
    <?php
    if($date_type == 0) {
    ?>
      <div class="row" style="padding-top:30px;">
        <!-- table starts -->
        <?php
        $diff = $date2_ts - $date1_ts;
        $dateDiff = round($diff / 86400);
        ?>
        <table id="tblData" class="table table-bordered" style="font-size:10px;width:100%;">
          <thead>
            <tr>
              <th rowspan="2">Branch</th>
              <th>Name</th>
              <th>Code</th>
              <th colspan="<?php echo ($dateDiff+1)*2+1; ?>" style="text-align:center;"></th>
            </tr>
            <tr>
              <th><?php if($branch_type == 0) echo $branch_obj->name; else echo "All Branches";?></th>
              <th><?php if($branch_type == 0) echo $branch_obj->code; ?></th>
              <th colspan="<?php echo ($dateDiff+2)*2+1; ?>" style="text-align:center;">Service Code Report</th>
            </tr>
            <tr>
              <th>S/No</th>
              <th>Service Code</th>
              <?php
              $date1_ts = $from_date_val;
              $date2_ts = $to_date_val;

              while ($date1_ts <= $date2_ts) {
                $datelabel = date('m/d', $date1_ts);
                echo "<th colspan='2'>" . $datelabel . "</th>";
                $date1_ts = strtotime('+1 days', $date1_ts);
              }
              echo "<th colspan='2' style='text-align:center;'>Total</th>";
              echo "<th colspan='2' style='text-align:center;'>Units</th>";
              ?>
            </tr>
            <tr>
              <th></th>
              <th></th>
              <?php
              $daily_item2 = array();
              $daily_item4 = array();

              $product_item2 = array();
              $product_item4 = array();

              foreach(ProductCode::find_all() as $cat_data){
                $product_item2[$cat_data->code] = array();
                $product_item4[$cat_data->code] = array();
              }

              $date1_ts = $from_date_val;
              $date2_ts = $to_date_val;

              while ($date1_ts <= $date2_ts) {
                $datelabel = date('m/d', $date1_ts);
                echo "<th> S </th>";
                echo "<th> R </th>";
                $date1_ts = strtotime('+1 days', $date1_ts);

                $daily_item2[] = 0;
                $daily_item4[] = 0;

                foreach(ProductCode::find_all() as $cat_data){
                  $product_item2[$cat_data->code][] = 0;
                  $product_item4[$cat_data->code][] = 0;
                }
              }
              echo "<th> S </th>";
              echo "<th> R </th>";
              echo "<th> S </th>";
              echo "<th> R </th>";
              ?>
            </tr>
          </thead>
          <tbody>
            <!-- body start -->
            <?php
            if(isset($from_date_val) && isset($to_date_val) ) {
              $servicecounter = 1;

              foreach(Service::find_all() as $service_data) {
                $service_code = $service_data->code;
                if(strpos($service_code, "CO") !== 0) {
                  $total_item2 = 0;
                  $total_item4 = 0;

                  $count = 0;

                  echo "<tr>";
                  echo "<td>" . $servicecounter . "</td>";
                  echo "<td>". $service_data->code . "</td>";

                  $date1_ts = $from_date_val;
                  $date2_ts = $to_date_val;

                  $day_index = 0;
                  while ($date1_ts <= $date2_ts) {
                    $count = 0;

                    if($branch_type == 0)
                      $item_data = InvoiceSub::find_by_type_code(2, $service_data->code, date('Y-m-d', $date1_ts), $branch_id);
                    else
                      $item_data = InvoiceSub::find_by_type_code_without_branch(2, $service_data->code, date('Y-m-d', $date1_ts));

                    // $item_data = InvoiceSub::find_by_type_code(2, $service_data->code, date('Y-m-d', $date1_ts), $branch);

                    foreach($item_data as $live_count) {
                      $count = $count + $live_count->qty;

                      $service_products = ProductUsageServices::find_by_code($live_count->code);
                      foreach($service_products as $service_product) {
                        $product_codes = explode(",", $service_product->p_use_code);
                        $product_volumes = explode(",", $service_product->volume);

                        $product_index = 0;
                        foreach($product_codes as $product_code) {
                          $product_code = trim($product_code);
                          if(array_key_exists($product_code, $product_item2)) {
                            $product_item2[$product_code][$day_index] += floatval(trim($product_volumes[$product_index]));
                          }
                          $product_index++;
                        }
                      }
                    }
                    $daily_item2[$day_index] += $count;
                    $total_item2 = $total_item2 + $count;
                    echo "<td>" . $count . "</td>";

                    $count = 0;

                    if($branch_type == 0)
                      $item_data = InvoiceSub::find_by_type_code(4, $service_data->code, date('Y-m-d', $date1_ts), $branch_id);
                    else
                      $item_data = InvoiceSub::find_by_type_code_without_branch(4, $service_data->code, date('Y-m-d', $date1_ts));

                    // $item_data = InvoiceSub::find_by_type_code(4, $service_data->code, date('Y-m-d', $date1_ts), $branch);

                    foreach($item_data as $live_count) {
                      $count = $count + $live_count->qty;

                      $service_products = ProductUsageServices::find_by_code($live_count->code);
                      foreach($service_products as $service_product) {
                        $product_codes = explode(",", $service_product->p_use_code);
                        $product_volumes = explode(",", $service_product->volume);

                        $product_index = 0;
                        foreach($product_codes as $product_code) {
                          $product_code = trim($product_code);
                          if(array_key_exists($product_code, $product_item4)) {
                            $product_item4[$product_code][$day_index] += floatval(trim($product_volumes[$product_index]));
                          }
                          $product_index++;
                        }
                      }
                    }
                    $daily_item4[$day_index] += $count;
                    $total_item4 = $total_item4 + $count;
                    echo "<td>" . $count . "</td>";

                    $date1_ts = strtotime('+1 days', $date1_ts);

                    $day_index++;
                  }

                  echo "<td>".$total_item2."</td>";
                  echo "<td>".$total_item4."</td>";
                  echo "<td></td>";
                  echo "<td></td>";
                  echo "</tr>";

                  $servicecounter = $servicecounter + 1;
                }
              }

              // $total_item2 = 0;
              // $total_item4 = 0;

              // $count = 0;
              // $countt = 0;

              // echo "<tr>";
              // echo "<td colspan='2'>Total</td>";

              // $date1_ts = $from_date_val;
              // $date2_ts = $to_date_val;

              // $day_index = 0;
              // while ($date1_ts <= $date2_ts) {
              //   echo "<td>" . $daily_item2[$day_index] . "</td>";
              //   echo "<td>" . $daily_item4[$day_index] . "</td>";
              //   $date1_ts = strtotime('+1 days', $date1_ts);
              //   $total_item2 = $total_item2 + $daily_item2[$day_index];
              //   $total_item4 = $total_item4 + $daily_item4[$day_index];
              //   $day_index++;
              // }

              // echo "<td>".$total_item2."</td>";
              // echo "<td>".$total_item4."</td>";
              // echo "</tr>";


              echo "<tr>";
              echo "<td></td>";
              echo "<td>Product Used</td>";
              $col_span = ($dateDiff+2)*2;
              echo "<td colspan='$col_span' style='text-align:center;'></td> ";
              echo "</tr>";


              foreach(ProductCode::find_all() as $product_code) {
                $total_item2 = 0;
                $total_item4 = 0;

                echo "<tr>";
                echo "<td></td>";
                echo "<td>". $product_code->code . "</td>";

                $date1_ts = $from_date_val;
                $date2_ts = $to_date_val;

                $day_index = 0;
                while ($date1_ts <= $date2_ts) {
                  $total_item2 += $product_item2[$product_code->code][$day_index];
                  $total_item4 += $product_item4[$product_code->code][$day_index];

                  echo "<td>" . $product_item2[$product_code->code][$day_index] . "</td>";
                  echo "<td>" . $product_item4[$product_code->code][$day_index] . "</td>";

                  $date1_ts = strtotime('+1 days', $date1_ts);

                  $day_index++;
                }

                echo "<td>".$total_item2."</td>";
                echo "<td>".$total_item4."</td>";
                
                $product_units = ProductUnit::check_code($product_code->code);
                if(count($product_units) == 1) {
                  $product_unit = $product_units[0];
                  $total_unit2 = round((floatval($total_item2) / floatval($product_unit->p_volume)), 1);
                  $total_unit4 = round((floatval($total_item4) / floatval($product_unit->p_volume)), 1);
                  echo "<td>". $total_unit2 ."mo</td>";
                  echo "<td>". $total_unit4 ."sin</td>";
                } else {
                  echo "<td>0</td>";
                  echo "<td>0</td>";
                }
                echo "</tr>";
              }
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
    if($date_type == 1) {
    ?>
      <div class="row" style="padding-top:30px;">
        <!-- table starts -->
        <?php
        $month = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        ?>
        <table id="tblData" class="table table-bordered" style="font-size:10px;width:100%;">
          <thead>
            <tr>
              <th rowspan="2">Branch</th>
              <th>Name</th>
              <th>Code</th>
              <th colspan="27" style="text-align:center;"></th>
            </tr>
            <tr>
              <th><?php if($branch_type == 0) echo $branch_obj->name; else echo "All Branches";?></th>
              <th><?php if($branch_type == 0) echo $branch_obj->code; ?></th>
              <th colspan="27" style="text-align:center;">Service Code Report</th>
            </tr>
            <tr>
              <th>S/No</th>
              <th>Service Code</th>
              <?php
              for($i=0; $i<12; $i++) {
                print '<th colspan="2" style="text-align: center;">'.$month[$i].'</th>';
              }
              echo "<th colspan='2' style='text-align:center;'>Total</th>";
              echo "<th colspan='2' style='text-align:center;'>Units</th>";
              ?>
            </tr>
            <tr>
              <th></th>
              <th></th>
              <?php
              $daily_item2 = array();
              $daily_item4 = array();

              $product_item2 = array();
              $product_item4 = array();

              foreach(ProductCode::find_all() as $cat_data){
                $product_item2[$cat_data->code] = array();
                $product_item4[$cat_data->code] = array();
              }

              for($i=0; $i<12; $i++) {
                echo "<th> S </th>";
                echo "<th> R </th>";

                $daily_item2[] = 0;
                $daily_item4[] = 0;

                foreach(ProductCode::find_all() as $cat_data){
                  $product_item2[$cat_data->code][] = 0;
                  $product_item4[$cat_data->code][] = 0;
                }
              }
              echo "<th> S </th>";
              echo "<th> R </th>";
              echo "<th> S </th>";
              echo "<th> R </th>";
              ?>
            </tr>
          </thead>
          <tbody>
            <!-- body start -->
            <?php
            if(isset($_POST['year'])) {
              $year = $_POST['year'];
              $servicecounter = 1;

              foreach(Service::find_all() as $service_data) {
                $service_code = $service_data->code;
                if(strpos($service_code, "CO") !== 0) {
                  $total_item2 = 0;
                  $total_item4 = 0;

                  $count = 0;

                  echo "<tr>";
                  echo "<td>" . $servicecounter . "</td>";
                  echo "<td>". $service_data->code . "</td>";

                  $day_index = 0;
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
                      $item_data = InvoiceSub::find_by_type_branch_code_type_date_range(2, $service_code, $_POST['branch'], $strdate1, $strdate2);
                    else
                      $item_data = InvoiceSub::find_by_type_branch_code_type_date_range_without_branch(2, $service_code, $strdate1, $strdate2);

                    foreach($item_data as $live_count) {
                      $count = $count + $live_count->qty;

                      $service_products = ProductUsageServices::find_by_code($live_count->code);
                      foreach($service_products as $service_product) {
                        $product_codes = explode(",", $service_product->p_use_code);
                        $product_volumes = explode(",", $service_product->volume);

                        $product_index = 0;
                        foreach($product_codes as $product_code) {
                          $product_code = trim($product_code);
                          if(array_key_exists($product_code, $product_item2)) {
                            $product_item2[$product_code][$day_index] += floatval(trim($product_volumes[$product_index])) * $live_count->qty;
                          }
                          $product_index++;
                        }
                      }
                    }
                    $daily_item2[$day_index] += $count;
                    $total_item2 = $total_item2 + $count;
                    echo "<td>" . $count . "</td>";

                    $count = 0;

                    if($branch_type == 0)
                      $item_data = InvoiceSub::find_by_type_branch_code_type_date_range(4, $service_code, $_POST['branch'], $strdate1, $strdate2);
                    else
                      $item_data = InvoiceSub::find_by_type_branch_code_type_date_range_without_branch(4, $service_code, $strdate1, $strdate2);

                    foreach($item_data as $live_count) {
                      $count = $count + $live_count->qty;

                      $service_products = ProductUsageServices::find_by_code($live_count->code);
                      foreach($service_products as $service_product) {
                        $product_codes = explode(",", $service_product->p_use_code);
                        $product_volumes = explode(",", $service_product->volume);

                        $product_index = 0;
                        foreach($product_codes as $product_code) {
                          $product_code = trim($product_code);
                          if(array_key_exists($product_code, $product_item4)) {
                            $product_item4[$product_code][$day_index] += floatval(trim($product_volumes[$product_index])) * $live_count->qty;
                          }
                          $product_index++;
                        }
                      }
                    }
                    $daily_item4[$day_index] += $count;
                    $total_item4 = $total_item4 + $count;
                    echo "<td>" . $count . "</td>";

                    $day_index++;
                  }

                  echo "<td>".$total_item2."</td>";
                  echo "<td>".$total_item4."</td>";
                  echo "<td></td>";
                  echo "<td></td>";
                  echo "</tr>";

                  $servicecounter = $servicecounter + 1;
                }
              }

              // $total_item2 = 0;
              // $total_item4 = 0;

              // $count = 0;
              // $countt = 0;

              // echo "<tr>";
              // echo "<td colspan='2'>Total</td>";

              // $day_index = 0;
              // for($i=0; $i<12; $i++) {
              //   echo "<td>" . $daily_item2[$day_index] . "</td>";
              //   echo "<td>" . $daily_item4[$day_index] . "</td>";
              //   $total_item2 = $total_item2 + $daily_item2[$day_index];
              //   $total_item4 = $total_item4 + $daily_item4[$day_index];
              //   $day_index++;
              // }

              // echo "<td>".$total_item2."</td>";
              // echo "<td>".$total_item4."</td>";
              // echo "</tr>";


              echo "<tr>";
              echo "<td></td>";
              echo "<td>Product Used</td>";
              $col_span = 28;
              echo "<td colspan='$col_span' style='text-align:center;'></td> ";
              echo "</tr>";


              foreach(ProductCode::find_all() as $product_code) {
                $total_item2 = 0;
                $total_item4 = 0;

                echo "<tr>";
                echo "<td></td>";
                echo "<td>". $product_code->code . "</td>";

                $day_index = 0;
                for($i=0; $i<12; $i++) {
                  $total_item2 += $product_item2[$product_code->code][$day_index];
                  $total_item4 += $product_item4[$product_code->code][$day_index];

                  echo "<td>" . $product_item2[$product_code->code][$day_index] . "</td>";
                  echo "<td>" . $product_item4[$product_code->code][$day_index] . "</td>";

                  $day_index++;
                }

                echo "<td>".$total_item2."</td>";
                echo "<td>".$total_item4."</td>";

                $product_units = ProductUnit::check_code($product_code->code);
                if(count($product_units) == 1) {
                  $product_unit = $product_units[0];
                  $total_unit2 = round((floatval($total_item2) / floatval($product_unit->p_volume)), 1);
                  $total_unit4 = round((floatval($total_item4) / floatval($product_unit->p_volume)), 1);
                  echo "<td>". $total_unit2 ."</td>";
                  echo "<td>". $total_unit4 ."</td>";
                } else {
                  echo "<td>0</td>";
                  echo "<td>0</td>";
                }

                echo "</tr>";
              }
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
