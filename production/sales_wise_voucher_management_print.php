<?php
require_once './../util/initialize.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title> VOUCHER MANAGEMENT </title>
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
        <table id="tblData" class="table table-striped table-bordered dt-responsive nowrap"  cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>Voucher Date</th>
              <th>Voucher Number</th>
              <th>Voucher Type</th>
              <th style="text-align:center;">Voucher Message</th>
              <th style="text-align:center;">Voucher Value</th>
              <th style="text-align:center;">Customer Name</th>
              <th style="text-align:center;">Voucher Value</th>
              <th style="text-align:center;">Voucher Code</th>
            </tr>
          </thead>
          <tbody>

            <?php
            $objects = Voucher::find_all();
            foreach ($objects as $data) {
              // echo '<pre>';
              // print_r($data);
              ?>
              
              <tr>
                <td><?php echo $data->voucher_date; ?></td>
                <td style="text-align:center;"><?php echo $data->voucher_number; ?></td>
                <?php
                if($data->voucher_type == 1){
                  echo "<td>Voucher For Sales Wise</td>";
                }else if($data->voucher_type == 2){
                  echo "<td>Voucher For Birthday Month</td>";
                }else if($data->voucher_type == 3){
                  echo "<td>Voucher For Joined Month</td>";
                }else if($data->voucher_type == 4){
                  echo "<td>Voucher For Selected Customer</td>";
                }else{
                  echo "<td style='text-align:center;'>-</td>";
                }
                ?>
                <?php if(!empty($data->voucher_message)){ ?>
                <td style="text-align:center;"><?php echo $data->voucher_message; ?></td>
                <?php }else{ ?>
                  <td style="text-align:center;"></td>
                <?php } ?>
                <td style="text-align:center;"><?php echo $data->voucher_value; ?></td>
                <td style="text-align:center;"><?php echo $data->customer_id()->full_name; ?></td>
                <?php
                  if($data->voucher_value_type == 1){
                    $sym = '';
                  }else{
                    $sym = '%';
                  }
                ?>
                <td style="text-align:center;"> <?php echo $data->voucher_value.$sym; ?></td>
                <td style="text-align:center;"> <?php echo $data->voucher_number; ?></td>
              </tr>
              <?php
            }
            ?>

          </tbody>
        </table>

        <!-- table ends -->
      </div>
  </div>

</body>
</html>
