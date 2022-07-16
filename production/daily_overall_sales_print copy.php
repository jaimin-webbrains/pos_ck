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


    <div class="row" style="padding-top:30px;">

      <!-- table starts -->


      <table id="tblData" class="table table-bordered" style="font-size:10px;width:100%;">
        <thead>
          <tr>
            <th>No.</th>
            <th>Outlet</th>

            <?php
            $list=array();
            $year = $_POST['year'];
            $month = $_POST['month'];

            for($d=1; $d<=31; $d++)
            {
              $time=mktime(12, 0, 0, $month, $d, $year);
              if (date('m', $time)==$month)
              // $list[]=date('Y-m-d-D', $time);
              $list[]=date('d-M', $time);
            }
            foreach($list as $data){
              echo "<th style='text-align:right;'>".$data."</th>";
            }
            ?>
            <th style='text-align:right;'>Total</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $count = 1;
          $total_voucher_value_default=0;
          foreach(Branch::find_all() as $branch_data){
            echo "<tr>";
            echo "<td>".$count."</td>";
            echo "<td>".$branch_data->name."</td>";

            $list=array();
            $year = $_POST['year'];
            $month = $_POST['month'];

            for($d=1; $d<=31; $d++)
            {
              $time=mktime(12, 0, 0, $month, $d, $year);
              if (date('m', $time)==$month)
              // $list[]=date('Y-m-d-D', $time);
              $list2[]=date('Y-m-d', $time);
            }
            $line_total = 0;
            foreach($list2 as $data){
              $invoice_total = 0;
              $invoice_total2 = 0;
   //           foreach( Invoice::find_by_branch_date($branch_data->id,$data) as $invoice_data ){
      foreach( Invoice::find_by_branch_date($data,$branch_data->id) as $invoice_data ){

        $voucher = Voucher::find_by_voucher_number($invoice_data->invoice_voucher);
        if(isset($voucher->voucher_value)){
        $total_voucher_value_default=$voucher->voucher_value+$total_voucher_value_default;
        
        // echo '<pre>';
        // print_r($invoice_data->invoice_payment);
        $invoice_total = $invoice_total + $invoice_data->invoice_total;
        $invoice_total2 = $invoice_total2 + $invoice_data->invoice_payment;
      //   if(!empty($voucher)){
      //     if($voucher->voucher_value_type == 0){
      //       $total_voucherr = $invoice_total * $total_voucher_value_default/100;
      //       echo '<pre>';
      //       print_r($total_voucher_value_default);
      //     }else{
      //       $total_voucherr = $invoice_total - $total_voucher_value_default;
      //     }
      //   }
        }
      }
              if($invoice_total2 > 0){
                echo "<td>".number_format($invoice_total2,2)."</td>";
              }else{
                echo "<td>-</td>";
              }
              $line_total = $line_total + $invoice_total2;
            }
            echo "<td style='text-align:right;'>".number_format($line_total,2)."</td>";
            echo"</tr>";
            ++$count;
            $list2 = NULL;
          }
          ?>
        </tbody>
      </table>

      <!-- table ends -->
    </div>

  </div>

</body>
</html>
