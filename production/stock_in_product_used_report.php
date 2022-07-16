<?php
require_once './../util/initialize.php';
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

    <button class="btn btn-primary" onclick="exportTableToExcel('tblData')">Export Table Data To Excel File</button>
    <hr/>
    <!-- table start -->

    <table class="table table-bordered" style="font-size:10px;" id="tblData">
      <thead>
        <tr>
          <th>S/N</th>
          <th>Product Code</th>
          <?php
          if(isset($_POST['branch_id']) && isset($_POST['search_date']) && isset($_POST['search_date_to'])){
            $period = new DatePeriod(
              new DateTime($_POST['search_date']),
              new DateInterval('P1D'),
              new DateTime($_POST['search_date_to'])
            );

            foreach ($period as $key => $value) {
              //$value->format('Y-m-d')
              echo "<th>".$value->format('Y-m-d')."</th>";
            }

          }
          ?>
          <th>Stock Rotate</th>
          <th>Stock Writeoff</th>
          <th>Stock in</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sn = 1;
        $flow = 0;
        foreach( Product::find_all() as $product_data ){
          echo "<tr>";

          echo "<td>".$sn."</td>";
          echo "<td>".$product_data->code."</td>";
          $stock_out_total = 0;
          foreach ($period as $key => $value) {
            $product_total = 0;

            if($product_data->brand != 1){
            foreach(InvoiceSub::find_by_invoice_id_date_range_branch($_POST['branch_id'], $value->format('Y-m-d')) as $invoice_sub_data ) {
              // echo $invoice_sub_data->code."<br/>";
              foreach(ProductUsageServices::find_by_code($invoice_sub_data->code) as $usage_data){

                $p_user_array = explode(',', $usage_data->p_use_code);
                $valoume_array = explode(',', $usage_data->volume);

                $array_location = 0;
                foreach ($p_user_array as $value) {
                  if($product_data->code == $value){
                    $product_total = $product_total + ($valoume_array[$array_location] * $invoice_sub_data->qty );
                    // echo $valoume_array[$array_location]."</br>";
                  }
                  ++$array_location;
                }

              }

            }
            // echo "------------------------------------------------------";
          }else{

            foreach(InvoiceSub::find_by_invoice_id_date_range_product_branch($product_data->code, $_POST['branch_id'], $value->format('Y-m-d')) as $invoice_sub_data ) {

              foreach(ColourTube::find_by_code($product_data->code) as $usage_data){
                $product_total = $product_total + $usage_data->capacity;
              }
            }

          }

            if($product_total == 0){
              echo "<td style='text-align:center;'>0</td>";
            }else{
              echo "<td style='text-align:center;'><b>".$product_total."</b></td>";
            }
          }


          $StockRotate = 0;
          $StockRotate = $StockRotate + count(StockRotateSales::find_by_dates_code( $_POST['search_date'], $_POST['search_date_to'], $product_data->code, $_POST['branch_id'] ));
          $StockRotate = $StockRotate + count(StockRotateUsage::find_by_dates_code( $_POST['search_date'], $_POST['search_date_to'], $product_data->code, $_POST['branch_id'] ));

          if($StockRotate == 0){
            echo "<td style='text-align:center;'>0</td>";
          }else{
            echo "<td style='text-align:center;'>".$StockRotate."</td>";
          }


          $StockWriteOff = 0;
          foreach(StockWriteOffSales::find_by_dates_code( $_POST['search_date'], $_POST['search_date_to'], $product_data->code, $_POST['branch_id'] ) as $recieve_data) {
            $StockWriteOff = $StockWriteOff + $recieve_data->write_off_quantity;
          }
          foreach(StockWriteOffUsage::find_by_dates_code( $_POST['search_date'], $_POST['search_date_to'], $product_data->code, $_POST['branch_id'] ) as $recieve_data) {
            $StockWriteOff = $StockWriteOff + $recieve_data->write_off_quantity;
          }
          if($StockWriteOff == 0){
            echo "<td style='text-align:center;'>0</td>";
          }else{
            echo "<td style='text-align:center;'>".$StockWriteOff."</td>";
          }


          $recieve_total = 0;
          foreach(StockReceive::find_by_dates_code( $_POST['search_date'], $_POST['search_date_to'], $product_data->code ) as $recieve_data) {
            $recieve_total = $recieve_total + $recieve_data->quantity;
          }
          if($recieve_total == 0){
            echo "<td style='text-align:center;'>0</td>";
          }else{
            echo "<td style='text-align:center;'>".$recieve_total."</td>";
          }

          echo "<td style='text-align:right;'>".($recieve_total - ($stock_out_total + $StockRotate + $StockWriteOff))."</td>";

          echo "</tr>";
          ++$sn;
        }
        ?>
      </tbody>
    </table>

    <!-- table ends -->
  </div>

</body>
</html>
