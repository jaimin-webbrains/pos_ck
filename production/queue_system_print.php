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

    <hr/>

    <table id="tblData" class="table table-bordered" style="font-size:10px;width:100%;">
      <thead>
        <tr>
          <th>S/no</th>
          <th>Customer No</th>
          <th>Queue Number</th>
          <th>Branch</th>
          <th>Queue Issue Time</th>
          <th>Service Starf Assigned</th>
        </tr>
      </thead>
      <tbody>

        <?php
        if(isset($_POST['from_date']) && $_POST['to_date']){
          $from_date = $_POST['from_date'];
          $to_date = $_POST['to_date'];

          $step = 1;
          foreach(Queue::find_date_range($from_date,$to_date) as $queue_data){
            echo "<tr>";
            echo "<td>".$step."</td>";
            echo "<td>".$queue_data->customer_id()->full_name."</td>";
            echo "<td>".$queue_data->queue_number."</td>";
            echo "<td>".$queue_data->branch_id()->name."</td>";
            echo "<td>".$queue_data->que_date_time."</td>";

            echo "<td>";
            $invoice_data = Invoice::find_all_queue($queue_data->id);
            if(count($invoice_data) > 0){
              foreach ($invoice_data as $inv_data) {
                $service = InvoiceSub::find_all_invoice_id_last($inv_data->id);
                echo $service->ops1_user()->name." / ".$service->ops2_user()->name;
              }
            }
            echo "</td>";

            echo "</tr>";
            ++$step;
          }

        }
        ?>

      </tbody>
    </table>

    <!-- table ends -->
  </div>
</div>

</body>
</html>
