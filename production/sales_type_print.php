<?php
require_once './../util/initialize.php';
$con=mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Branch & Employee Report</title>
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
              <th rowspan="2">Code: <br/> <?php echo $branch_obj->code; ?></th>
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
              echo "<th style='text-align:center;'>Total Customer</th>";
              ?>
            </tr>

            <tr>
              <th>S/no</th>
              <th colspan='2'>SALES TYPE</th>
              <?php
              foreach ($cat_object as $cat_data) {
                echo "<th style='text-align:center;' colspan='3'></th>";
              }
              foreach ($pro_object as $pro_data) {
                echo "<th colspan='3' style='text-align:center;'></th>";

              }
              echo "<th style='text-align:center;'></th>";
              echo "<th style='text-align:center;'></th>";

              ?>

            </tr>
          </thead>
          <tbody>
            <!-- body start -->
            <?php
            if(isset($_POST['branch']) && isset($_POST['from_date']) && isset($_POST['to_date']) ){

              $branch = $_POST['branch'];
              $from = $_POST['from_date'];
              $to = $_POST['to_date'];

              echo "<tr>";
              echo "<td>1</td>";
              echo "<td colspan='2'>Service</td>";
              $total = 0;
              $Cust_total = 0;
              $total_salon = 0;
              $summary_total = 0;
              $grand_total = 0;
              foreach(ServiceCategory::find_all() as $cat_data){
                $count = 0;
                $countt = 0;
                $item_data = InvoiceSub::find_by_type_cat(2, $cat_data->name, $from, $to, $branch);
                
                foreach($item_data as $live_count){
                  $count = $count + $live_count->qty;
                  $countt = $countt + ($live_count->qty * $live_count->unit_price);
                  $invoice_data = Invoice::find_by_invoice_customer_total($live_count->invoice_id);
                  $Cust_total = $Cust_total + $invoice_data;
                }
                $total = $total + $countt;
                
                echo "<td colspan='3'>".$count."</td>";
              }
              $total_salon = $total;
              foreach(ProductCategory::find_all() as $cat_data){
                echo "<td colspan='3'>0</td>";
              }
              echo "<td>".$total."</td>";
              echo "<td>".$Cust_total."</td>";
              echo "</tr>";

              echo "<tr>";
              echo "<td>2</td>";
              echo "<td colspan='2'>Package</td>";
              $total = 0;
              $Cust_total = 0;
              $ops1 = 0;
              $ops2 = 0;
              foreach(ServiceCategory::find_all() as $cat_data){
                $count = 0;
                $countt = 0;
                $ops1_count = 0;
                $ops2_count = 0;
                $item_data = InvoiceSub::find_by_type_cat(3, $cat_data->name, $from, $to, $branch);
                foreach($item_data as $live_count){
                  $count = $count + $live_count->qty;
                  $countt = $countt + ($live_count->qty * $live_count->unit_price);
                  $invoice_data = Invoice::find_by_invoice_customer_total($live_count->invoice_id);
                  $Cust_total = $Cust_total + $invoice_data;
                  $ops1_count = $ops1_count + $live_count->ops1;
                  $ops2_count = $countt - $ops1_count;
                }
                $total = $total + $countt;
                $ops1 = $ops1 + $ops1_count;
                $ops2 = $ops2 + $ops2_count;
                echo "<td colspan='3'>".$count."</td>";
              }
              foreach(ProductCategory::find_all() as $cat_data){
                echo "<td colspan='3'>0</td>";
              }
              echo "<td>".$total."</td>";
              echo "<td>".$Cust_total."</td>";
              echo "</tr>";

              echo "<tr>";
              echo "<td>3</td>";
              echo "<td colspan='2'>Redumption</td>";
              $total = 0;
              $Cust_total = 0;
              foreach(ServiceCategory::find_all() as $cat_data){
                $count = 0;
                $countt = 0;
                $item_data = InvoiceSub::find_by_type_cat(4, $cat_data->name, $from, $to, $branch);
                foreach($item_data as $live_count){
                  $count = $count + $live_count->qty;
                  $countt = $countt + ($live_count->qty * $live_count->unit_price);
                  $invoice_data = Invoice::find_by_invoice_customer_total($live_count->invoice_id);
                  $Cust_total = $Cust_total + $invoice_data;
                }
                $total = $total + $countt;
                echo "<td colspan='3'>".$count."</td>";
              }
              foreach(ProductCategory::find_all() as $cat_data){
                echo "<td colspan='3'>0</td>";
              }
              echo "<td>".$total."</td>";
              echo "<td>".$Cust_total."</td>";
              echo "</tr>";

              echo "<tr>";
              echo "<td>4</td>";
              echo "<td colspan='2'>Product</td>";
              foreach(ServiceCategory::find_all() as $cat_data){
                echo "<td colspan='3'>0</td>";
              }
              $total = 0;
              $Cust_total = 0;
              $product_15 = 0;
              $product_10 = 0;
              $product_other = 0;
              foreach(ProductCategory::find_all() as $cat_data){
               
                $count = 0;
                $countt = 0;
                $product_others = 0;
                $item_data = InvoiceSub::find_by_type_cat(1, $cat_data->id, $from, $to, $branch);
                foreach($item_data as $live_count){
                  $count = $count + $live_count->qty;
                  $countt = $countt + ($live_count->qty * $live_count->unit_price);
                  $invoice_data = Invoice::find_by_invoice_customer_total($live_count->invoice_id);
                  $Cust_total = $Cust_total + $invoice_data;

                  if($live_count->category == 7){
                    $s_no = $live_count->s_no;
                    $sql = "SELECT * FROM product WHERE service_no = $s_no AND brand = 7"; 
                    $result=mysqli_fetch_assoc(mysqli_query($con,$sql));
                    $product_15 = ($product_15 + ($result['price'] * $result['ops_1']) / 100);
                  }else if($live_count->category == 9){
                    $s_no2 = $live_count->s_no;
                    $sql2 = "SELECT * FROM product WHERE service_no = $s_no2 AND brand = 9"; 
                    $result2=mysqli_fetch_assoc(mysqli_query($con,$sql2));
                    $product_10 = ($product_10 + ($result2['price'] * $result2['ops_1']) / 100);
                  }else{
                    $s_no3 = $live_count->s_no;
                    $sql3 = "SELECT * FROM product WHERE service_no = $s_no3 AND brand = 1"; 
                    $result3=mysqli_fetch_assoc(mysqli_query($con,$sql3));
                    $product_others = $product_others + ($live_count->qty * $live_count->unit_price);
                  }
                }
                $total = $total + $countt;
                $product_other = $product_other + $product_others;
                echo "<td colspan='3'>".$count."</td>";
              }
              echo "<td>".$total."</td>";
              echo "<td>".$Cust_total."</td>";
              echo "</tr>";

              echo "<tr>";
              echo "<td colspan='40'></td>";
              echo "</tr>";

              echo "<tr>";
              echo "<td colspan='40' style='text-align:center'>".'Summary of Salon Sales Performance'."</td>";
              echo "</tr>";

              echo "<tr>";
              echo "<td colspan='16' style='text-align:right'>Total Salon</td>";
              echo "<td colspan='2' style='text-align:center'>=</td>";
              echo "<td colspan='22' style='text-align:left'>".'RM '.number_format($total_salon,2)."</td>";
              echo "</tr>";

              echo "<tr>";
              echo "<td colspan='16' style='text-align:right'>Total Courses Pur(30% & 40%)</td>";
              echo "<td colspan='2' style='text-align:center'>=</td>";
              echo "<td colspan='22' style='text-align:left'>".'RM '.number_format($ops1,2)."</td>";
              echo "</tr>";

              echo "<tr>";
              echo "<td colspan='16' style='text-align:right'>Total Courses Pur(70% & 60%)</td>";
              echo "<td colspan='2' style='text-align:center'>=</td>";
              echo "<td colspan='22' style='text-align:left'>".'RM '.number_format($ops2,2)."</td>";
              echo "</tr>";

              echo "<tr>";
              echo "<td colspan='16' style='text-align:right'>Total Product(10%)</td>";
              echo "<td colspan='2' style='text-align:center'>=</td>";
              echo "<td colspan='22' style='text-align:left'>".'RM '.number_format($product_10,2)."</td>";
              echo "</tr>";

              echo "<tr>";
              echo "<td colspan='16' style='text-align:right'>Total Product(15%)</td>";
              echo "<td colspan='2' style='text-align:center'>=</td>";
              echo "<td colspan='22' style='text-align:left'>".'RM '.number_format($product_15,2)."</td>";
              echo "</tr>";
              $summary_total = $summary_total + ($total_salon + $ops1 + $ops2 + $product_10 + $product_15);
              echo "<tr>";
              echo "<td colspan='16' style='text-align:right'>Total</td>";
              echo "<td colspan='2' style='text-align:center'>=</td>";
              echo "<td colspan='22' style='text-align:left'>".'RM '.number_format($summary_total,2)."</td>";
              echo "</tr>";

              echo "<tr>";
              echo "<td colspan='16' style='text-align:right'>Total Others</td>";
              echo "<td colspan='2' style='text-align:center'>=</td>";
              echo "<td colspan='22' style='text-align:left'>".'RM '.number_format($product_other,2)."</td>";
              echo "</tr>";
              $grand_total = $grand_total + ($summary_total + $product_other);
              echo "<tr>";
              echo "<td colspan='16' style='text-align:right'>Grand Total</td>";
              echo "<td colspan='2' style='text-align:center'>=</td>";
              echo "<td colspan='22' style='text-align:left'>".'RM '.number_format($grand_total,2)."</td>";
              echo "</tr>";
            }
            ?>
            <!-- body ends -->
          </tbody>
        </table>

        <!-- table ends -->
      </div>
    <?php } ?>
  </div>

</body>
</html>
