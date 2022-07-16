<?php
require_once './../util/initialize.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title> CUSTOMER WISE REPORT </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script type="text/javascript">
    function exportTableToExcel(tableID, filename = ''){
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
    if(isset($_POST['from_date']) && isset($_POST['to_date'])){
      $_POST['service_user'] = 1;
      // GET THE POST DATA
      $branch_id = $_POST['branch'];
      $service_user = $_POST['service_user'];
      $from_date = $_POST['from_date'];
      $to_date = $_POST['to_date'];

      // GET THE TABLE DATA
      $branch_obj = Branch::find_by_id($branch_id);
      $service_obj = User::find_by_id($service_user);

      ?>
      <div class="row" style="padding-top:30px;">

        <!-- table starts -->
        <?php
        $cat_object = ServiceCategory::find_all();
        $pro_object = ProductCategory::find_all();
        $category_count = count($cat_object) + count($pro_object);
        ?>

        <table id="tblData" class="table table-bordered" style="font-size:10px;width:100%;">
          <thead>
            <tr>
              <th rowspan="2">Branch <br/> Name:</th>
              <th rowspan="2"><?php echo $branch_obj->name; ?></th>
              <th rowspan="2" colspan="3" style="text-align:center;">Code: <br/> <?php echo $branch_obj->code; ?></th>
              <th colspan="<?php echo ($category_count*3)+3; ?>" style="text-align:center;">Category</th>
            </tr>
            <tr>
              <?php
              foreach ($cat_object as $cat_data) {
                echo "<th colspan='3'>".$cat_data->name."</th>";
              }
              foreach ($pro_object as $pro_data) {
                echo "<th colspan='3'>".$pro_data->name."</th>";
              }
              echo "<th style='text-align:center;'>Total Sales</th>";
              echo "<th style='text-align:center;'>Date Joined</th>";
              echo "<th style='text-align:center;'>Branch Joined</th>";
              ?>
            </tr>

            <tr>
              <th>S/no</th>
              <th>Customer No</th>
              <th>Customer Name</th>
              <th>Customer Phone</th>
              <th>Customer Email</th>
              <?php
              foreach ($cat_object as $cat_data) {
                echo "<th style='text-align:center;'>S</th>";
                echo "<th style='text-align:center;'>P</th>";
                echo "<th style='text-align:center;'>R</th>";
              }
              foreach ($pro_object as $pro_data) {
                echo "<th colspan='3' style='text-align:center;'>-</th>";

              }
              echo "<th style='text-align:center;'></th>";
              echo "<th style='text-align:center;'></th>";
              echo "<th style='text-align:center;'></th>";

              ?>

            </tr>
          </thead>
          <tbody>

            <?php
            // start table body
            if(isset($_POST['branch']) && isset($_POST['from_date']) && isset($_POST['to_date']) ){

              $branch = $_POST['branch'];
              $from = $_POST['from_date'];
              $to = $_POST['to_date'];

              $sn = 1;
              $customers = Invoice::find_by_customer($from, $to,$branch);
              foreach($customers as $customers_row ){
                  $customer = Customer::find_by_id($customers_row->customer_id);
                  // foreach( Customer::find_all() as $customer ){
                  echo "<tr>";
                  echo "<td>".$sn."</td>";
                  echo "<td>".$customer->id."</td>";
                  echo "<td>".$customer->full_name."</td>";
                  echo "<td>".$customer->mobile."</td>";
                  echo "<td>".$customer->email."</td>";

                  $total = 0;

                  // SERVICE PACKAGE REDUMPTOIN CAT
                  foreach(ServiceCategory::find_all() as $cat_data){
                    $result = InvoiceSub::find_by_customer_cat($customer->id, $cat_data->name, $from, $to, $branch);
                  
                    if(count($result) > 0){
                      $s = 0;
                      $p = 0;
                      $r = 0;
                      $st = 0;
                      $pt = 0;
                      $rt = 0;
                      foreach($result as $result_data){
                      
                        if($result_data->item_type == 2){
                          $s = $s + $result_data->qty;
                          $st = $st + ($result_data->qty * $result_data->unit_price);

                        }else if($result_data->item_type == 3){
                          $p = $p + $result_data->qty;
                          $pt = $pt + ($result_data->qty * $result_data->unit_price);

                        }else if($result_data->item_type == 4){
                          $r = $r + $result_data->qty;
                          $rt = $rt + ($result_data->qty * $result_data->unit_price);
                          
                        }
                      }
                      echo "<td>".$s."</td>";
                      echo "<td>".$p."</td>";
                      echo "<td>".$r."</td>";
                      $total = $total + $st;
                      $total = $total + $pt;
                      $total = $total + $rt;

                    }else{
                      echo "<td>-</td>";
                      echo "<td>-</td>";
                      echo "<td>-</td>";
                    }
                  }

                  // PRODUCT CATEGORY
                  foreach(ProductCategory::find_all() as $cat_data){
                    $result = InvoiceSub::find_by_customer_cat($customer->id,$cat_data->id, $from, $to, $branch);
                    $product = 0;
                    $productt = 0;
                    if(count($result) > 0){
                      foreach($result as $result_data){
                        $product = $product + $result_data->qty;
                        $productt = $productt + ($result_data->qty * $result_data->unit_price);
                      }
                      echo "<td colspan='3'>".$product."</td>";
                      $total = $total + $productt;
                    }else{
                      echo "<td colspan='3'>-</td>";
                    }
                  }
                  echo "<td>".$total."</td>";
                  echo "<td>".$customer->join_date."</td>";
                  echo "<td>".$branch_obj->name."</td>";
                  echo "</tr>";
                  ++$sn;
              }

            }
            // end table body
            ?>

          </tbody>
        </table>

        <!-- table ends -->
      </div>
    <?php } ?>
  </div>

</body>
</html>
