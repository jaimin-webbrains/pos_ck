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
				  <th>Voucher Number</th>
				     <th>Voucher Value</th>
				  <th>Service Commision</th>
				  <th>Product Commision</th>
                     <th>Package Commision</th>
					 <th>Redeem Commision</th>
				
					
					     
				  
                </tr>
              </thead>
              <tbody>

                <?php
                if(isset($_POST['from_date']) && isset($_POST['to_date'])){
                  // get the POST data
                  $from_date = $_POST['from_date'];
                  $to_date = $_POST['to_date'];
                  $user_id = $_SESSION["user"]["id"];
				  //echo "<h1>".$user_id."</h1>";
                  $sn = 1;
                  $ops1a = 0;
                  $ops1b = 0;
                  $ops2a = 0;
                  $ops2b = 0;
				  $total=0;
				  $voucher_val=0;
				  $service_comm=0;
				  $pro_comm=0;
				  $pkg_comm=0;
				  $rede_comm=0;
				  $vouchernumber=array();
				 // echo $from_date;
				  //echo $to_date;
				 // $q22="SELECT * FROM `invoice_sub` WHERE item_type=2  AND invoice_id=$calculatoon->invoice_id AND (`ops1_user`='$service_data->id' or `ops2_user`='$service_data->id')";
						
						// $retv22=mysqli_query($con,$q22);
                 
				  $sub_inv = InvoiceSub::find_by_invoice_id_date_range_invoice1($from_date, $to_date, $user_id); 
              		// print_r($sub_inv);		  
                  foreach($sub_inv as $data){
					  
					  $count_value=0;
					  $iid=$data->invoice_id()->id;
					$q22="SELECT * FROM `invoice_sub` WHERE  invoice_id='$iid' ";
					$retv22=mysqli_query($con,$q22);
					$inovice_rows=mysqli_num_rows($retv22);
						while($resu=mysqli_fetch_array($retv22))
						{
					//  print_r($data);
                    $sub_total = 0;
                    echo "<tr>";
                    echo "<td>".$sn."</td>";
                    echo "<td>".$data->invoice_id()->invoice_date."</td>";
				   //echo "<td>".$data->invoice_id"</td>";
                    echo "<td>".$data->invoice_id()->invoice_number."</td>";
                    echo "<td>".$data->invoice_id()->customer_id()->full_name."</td>";
					 
					
						
					 // $voucher = Voucher::find_by_voucher_number($data->invoice_id()->invoice_voucher);
					 // $vouchercheck=(in_array($data->invoice_id()->invoice_voucher,$vouchernumber))?1:0;
					  
					
					
					  $user_com_val=($resu['ops1_user']==$user_id)?$resu['ops1']:$resu['ops2'];
					   if($count_value==0){
						   $user_id=$_SESSION['user']['id'];
						     $total_voucher_query=mysqli_query($con,"select * from user_voucher_commission where invoice_id='$data->invoice_id' and user_id='$user_id'");
							 //echo "select * from user_voucher_commission where invoice_id='$data->invoice_id' ";
					$voucher_fetch=mysqli_fetch_array($total_voucher_query);
						   echo "<td rowspan='".$inovice_rows."'>".$data->invoice_id()->invoice_voucher."</td>";
               if(mysqli_num_rows($total_voucher_query)>0)
               {
					  	 echo "<td rowspan='".$inovice_rows."'>".$voucher_fetch['voucher_value']."</td>";
						 $voucher_val=$voucher_val+$voucher_fetch['voucher_value'];
						 //array_push($vouchernumber,$data->invoice_id()->invoice_voucher);
            }
            else
            {
              echo "<td rowspan='".$inovice_rows."'>-</td>";
            }
					   }
					   $count_value=$count_value+1;
					  // echo $resu['ops1_user']."  ".$resu['item_type']." ".$user_id."<br>"; 
						if($resu['ops1_user']==$user_id && $resu['item_type']==2)
						{
                   echo "<td style='text-align:right;'>".number_format($resu['ops1'],2)."</td>";
				   $service_comm=$service_comm+$resu['ops1'];
						}
						else if($resu['ops2_user']==$user_id && $resu['item_type']==2)
						{
                   echo "<td style='text-align:right;'>".number_format($resu['ops2'],2)."</td>";  
				   $service_comm=$service_comm+$resu['ops2'];
						}
						else
						{
							 echo "<td> - </td>";
						}
						if($resu['ops1_user']==$user_id && $resu['item_type']==1)
						{
                   echo "<td style='text-align:right;'>".number_format($resu['ops1'],2)."</td>";
				   $pro_comm=$pro_comm+$resu['ops1'];
						}
						else if($resu['ops2_user']==$user_id && $resu['item_type']==1)
						{
                   echo "<td style='text-align:right;'>".number_format($resu['ops2'],2)."</td>";  
				      $pro_comm=$pro_comm+$resu['ops2'];
						}
						else
						{
							 echo "<td> - </td>";
						}
						if($resu['ops1_user']==$user_id && $resu['item_type']==3)
						{
                   echo "<td style='text-align:right;'>".number_format($resu['ops1'],2)."</td>";
				      $pkg_comm=$pkg_comm+$resu['ops1'];
						}
						else if($resu['ops2_user']==$user_id && $resu['item_type']==3)
						{
                   echo "<td style='text-align:right;'>".number_format($resu['ops2'],2)."</td>";  
				      $pkg_comm=$pkg_comm+$resu['ops2'];
						}
						else
						{
							 echo "<td> - </td>";
						}
						if($resu['ops1_user']==$user_id && $resu['item_type']==4)
						{
                   echo "<td style='text-align:right;'>".number_format($resu['ops1'],2)."</td>";
				      $rede_comm=$rede_comm+$resu['ops1'];
						}
						else if($resu['ops2_user']==$user_id && $resu['item_type']==4)
						{
                   echo "<td style='text-align:right;'>".number_format($resu['ops2'],2)."</td>";  
				      $rede_comm=$rede_comm+$resu['ops2'];
						}
						else
						{
							 echo "<td> - </td>";
						}
						
						//echo "<td style='text-align:right;'>".number_format($resu['ops2'],2)."</td>";
                        //$ops2a =$ops2a+$resu['ops1_commision_a'];
                      //$ops2b =$ops2b+ $resu['ops1_commision_b'];

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
				}

                  echo "<tr style='font-size:20px;font-weight:700;background-color:teal;color:white;'>";
                  echo "<td colspan='5' style='text-align:right;'>SUB TOTAL: </td>";
                  echo "<td style='text-align:right;'>".number_format($voucher_val,2)."</td>";
				   echo "<td style='text-align:right;'>".number_format($service_comm,2)."</td>";
				    echo "<td style='text-align:right;'>".number_format($pro_comm,2)."</td>";
					 echo "<td style='text-align:right;'>".number_format($pkg_comm,2)."</td>";
					 echo "<td style='text-align:right;'>".number_format($rede_comm,2)."</td>";
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
