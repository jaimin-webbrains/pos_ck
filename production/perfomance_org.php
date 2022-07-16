<?php
require_once './../util/initialize.php';
include 'common/upper_content.php';
$con=mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
?>
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
<!--page content-->

    
<div class="right_col" role="main">
  <div class="">

    <?php Functions::output_result(); ?>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2 id="title" style="font-weight:700;"> - MY PERFOMANCE - </h2>
	
    <button class="btn btn-primary" onclick="exportTableToExcel('tblData')" style="float:right">Export Table Data To Excel File</button>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <!-- form start -->

            <form class="form-inline" method="post" action="perfomance.php">

              <div class="form-group">
                <label for="pwd">From Date:</label><br/>
                <input type="date" class="form-control" name="from_date" required>
              </div>

              <div class="form-group">
                <label for="pwd">To Date:</label><br/>
                <input type="date" class="form-control" name="to_date" required>
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

      <!-- SECOND COLUMN -->

      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_content">
            <!-- start content -->

            <table id="tblData" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>S/n</th>
                  <th>Invoice Date</th>
                  <th>Invoice Number</th>
                  <th>Customer Name</th>
				  <th>Service Commision</th>
				  <th>Product Commision</th>
              
				  
                </tr>
              </thead>
              <tbody>

                <?php
                if(isset($_POST['from_date']) && isset($_POST['to_date'])){
                  // get the POST data
                  $from_date = $_POST['from_date'];
                  $to_date = $_POST['to_date'];
                  $user_id = $_SESSION["user"]["id"];
                  $sn = 1;
                  $ops1a = 0;
                  $ops1b = 0;
                  $ops2a = 0;
                  $ops2b = 0;
				  $total=0;
				 // echo $from_date;
				  //echo $to_date;
				 // $q22="SELECT * FROM `invoice_sub` WHERE item_type=2  AND invoice_id=$calculatoon->invoice_id AND (`ops1_user`='$service_data->id' or `ops2_user`='$service_data->id')";
						
						// $retv22=mysqli_query($con,$q22);
                  $sub_inv = InvoiceSub::find_by_invoice_id_date_range_invoice($from_date, $to_date, $user_id); 
				  
        //         		 print_r($sub_inv);		  
                  foreach($sub_inv as $data){
					//  print_r($data);
                    $sub_total = 0;
                    echo "<tr>";
                    echo "<td>".$sn."</td>";
                    echo "<td>".$data->invoice_id()->invoice_date."</td>";
				   //echo "<td>".$data->invoice_id"</td>";
                    echo "<td>".$data->invoice_id()->invoice_number."</td>";
                    echo "<td>".$data->invoice_id()->customer_id()->full_name."</td>";
					
					$iid=$data->invoice_id()->id;
					$q22="SELECT ops1_commision_a,ops1_commision_b FROM `invoice_sub` WHERE  invoice_id='$iid' ";
					$retv22=mysqli_query($con,$q22);
						$resu=mysqli_fetch_array($retv22);
                   echo "<td style='text-align:right;'>".number_format($resu['ops1_commision_a'],2)."</td>";
                   echo "<td style='text-align:right;'>".number_format($resu['ops1_commision_b'],2)."</td>";  
                        $ops2a =$ops2a+$resu['ops1_commision_a'];
                      $ops2b =$ops2b+ $resu['ops1_commision_b'];

                     // $sub_total = 0;
                   // }
                  //  if($user_id == $data->ops2_user){
                      // echo "<td></td>";
                      // echo "<td></td>";
                      // echo "<td style='text-align:right;'>".number_format($data->ops2_commision_a,2)."</td>";
                      // echo "<td style='text-align:right;'>".number_format($data->ops2_commision_b,2)."</td>";
                    

                   //   $sub_total = $sub_total + $data->ops2_commision_a + $data->ops2_commision_b;
                 //   }

                   
					
                    echo "</tr>";
                    ++$sn;
                  }

                  echo "<tr style='font-size:20px;font-weight:700;background-color:teal;color:white;'>";
                  echo "<td colspan='4' style='text-align:right;'>SUB TOTAL: </td>";
                  echo "<td style='text-align:right;'>".number_format($ops2a,2)."</td>";
				   echo "<td style='text-align:right;'>".number_format($ops2b,2)."</td>";
                  echo "</tr>";



                }
                ?>

              </tbody>
            </table>

            <!-- end content -->
          </div>
        </div>
      </div>



    </div>
  </div>
</div>
<!--/page content-->
<?php include 'common/bottom_content.php'; ?> bottom content
<script>

</script>
