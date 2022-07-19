<?php
require_once './../util/initialize.php';
require_once 'common/pos_header.php';
$user = User::find_by_id($_SESSION["user"]["id"]);
$con=mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
?>
<style media="screen">
	.b1{
		font-weight: 700;
	}
</style>
<body>

<!-- content container starts -->
<div class="container-fluid">
	<div class="row" id='info-bar'>
		<div class="col-sm-8">
			<table class="table table-bordered">
				<tbody>
					<tr>
						<td colspan=2 >LOGGEDIN USER: <?php echo $user->name; ?> || Branch Name: <?php
						//$branch = Branch::find_by_id($user->branch_id);
						//echo $branch->name;
						?> || Code: <?php
						//$branch = Branch::find_by_id($user->branch_id);
						//echo $branch->code;
						?></td>
					</tr>
				</tbody>
			</table>
		</div>
		<?php require_once 'common/mini_header.php'; ?>
	</div>
</div>
<!--page content-->
<div class="right_col" role="main">
  <div class="container-fluid">
    <?php Functions::output_result(); ?>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_content" style="padding: 20px;">
            <form class="form-inline" method="post" action="customer_past_transaction.php">
              <div class="form-group" style="margin-right:30px;">
              <div class="form-group" style="margin-right:30px;">
                <div>
                  <label for="search_branch">Customer</label>  
                </div>
                <div>
					<?php $cust = $_POST['branch_id'];?>
                  <select class="form-control selectpicker" name="branch_id" data-live-search="true">
                    <option value="">Select Customer</option>
                  <?php
                    foreach(Customer::find_all() as $customer_data){
                    ?>
                      <option value="<?php echo $customer_data->id?>" <?php if($customer_data->id == $_POST['branch_id']) echo "selected"?>><?php echo $customer_data->full_name.'-'.$customer_data->mobile.'-'.$customer_data->email; ?></option>";
                    <?php
                      }
                  ?>
                  
                </select>
                </div>
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


      <!-- REPORT COLUMN -->
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_content" style="overflow-x:auto;">
            <!-- table start -->
            <table class="table table-bordered" id="report_table">
              <thead>
                <tr>
                  <th style='text-align:center;'>No</th>
                  <th style='text-align:center;'>Name</th>
                  <th style='text-align:center;'>Tel No</th>
                  <th style='text-align:center;'>Spending Amount</th>
                  <th style='text-align:center;'>Point</th>
                </tr>
              </thead>
              <tbody>
                <?php
                //report rows
                $total_amount = 0;
                $branch_id = NULL;
                $branch_condition = '';
				// echo '<pre>';
				// print_r(($_POST['branch_id']));
				// die;
                if(isset($_POST['branch_id'])){
                $branch_id = $_POST['branch_id'];
                }

                $sql = "SELECT invoice.id as invoice_id,SUM(invoice_payment) as total_spend,customer.*  FROM invoice JOIN customer on invoice.customer_id = customer.id WHERE customer_id = $branch_id group by customer_id ORDER BY total_spend desc"; 
                $result=mysqli_query($con,$sql);
                $no = 1;
                $total_spend  = 0;
                $points_total = 0; 
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        $total_points = 0;
                        $sql2 = "SELECT SUM(reward_points) as total_point FROM reward_point where customer_id =".$row['id']; 
                        $result2=mysqli_query($con,$sql2);
                        if (mysqli_num_rows($result2) > 0) {
                            $row2 = mysqli_fetch_assoc($result2);
                            $total_points = $row2['total_point'];
                        }
                        echo "<tr>";
                        echo "<td class='text-center'>".$no."</td>";
                        echo "<td class='text-center'>".$row['full_name']."</td>";
                        echo "<td class='text-center'>".$row['mobile']."</td>";
                        echo "<td class='text-center'>".$row['total_spend']."</td>";
                        echo "<td class='text-center'>".number_format($total_points,2)."</td>";
                        echo "</tr>";
                        $no++;
                        $total_spend += $row['total_spend'];
                        $points_total += $total_points;
                    }
                }

                ?>
              </tbody>
            </table>
            <!-- table ends -->
			<?php if($branch_id != NULL){ ?>
			<h5><strong>Recent Customer Transaction</strong></h5>
			<table class="table table-bordered" id="report_table">
              <thead>
                <tr>
                  <th style='text-align:center;'>No</th>
                  <th style='text-align:center;'>Invoice No</th>
                  <th style='text-align:center;'>Date</th>
				  <th style='text-align:center;'>Description</th>
                  <th style='text-align:center;'>Spending Amount</th>
                  <th style='text-align:center;'>Point</th>
                  <th style='text-align:center;'>OPS1</th>
                  <th style='text-align:center;'>OPS2</th>
                </tr>
              </thead>
              <tbody>
                <?php
                //report rows
                $total_amount = 0;
                $branch_id = NULL;
                $branch_condition = '';
				// echo '<pre>';
				// print_r(($_POST['branch_id']));
				// die;
                if(isset($_POST['branch_id'])){
                $branch_id = $_POST['branch_id'];
                }
////JOIN invoice_sub on invoice.id = invoice_sub.invoice_id
                $sql = "SELECT invoice.id as invoice_id, invoice_payment as total_spend, invoice.invoice_date, customer.*  FROM invoice JOIN customer on invoice.customer_id = customer.id WHERE customer_id = $branch_id ORDER BY invoice_date desc LIMIT 5"; 
                $result=mysqli_query($con,$sql);
                $no = 1;
                $total_spend  = 0;
                $points_total = 0; 
				
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        $total_points = 0;
                        $sql2 = "SELECT reward_points as total_point FROM reward_point where customer_id =".$row['id']; 
                        $result2=mysqli_query($con,$sql2);
                        if (mysqli_num_rows($result2) > 0) {
                            $row2 = mysqli_fetch_assoc($result2);
                            $total_points = $row2['total_point'];
                        }
						$sql3 = "SELECT `invoice_sub`.`name` as `servicename`, `invoice_sub`.`ops1_user`, `invoice_sub`.`ops2_user`, `users`.`name` as `ops1name`, `users2`.`name` as `ops2name` FROM invoice_sub JOIN users on users.id = ops1_user JOIN users as users2 on users2.id = ops2_user  where invoice_sub.invoice_id =".$row['invoice_id']; 
            $result3=mysqli_query($con,$sql3);          
						$servicename = '';
						if (mysqli_num_rows($result3) > 0) {
							while($row3 = mysqli_fetch_assoc($result3)) {
                $ops1= $row3['ops1name'];
                $ops2= $row3['ops2name'];
								if($servicename == ''){
									$servicename.= $row3['servicename'];
                 
								}else{
									$servicename.= ', '.$row3['servicename'];
								}
							}
                        }
                        echo "<tr>";
                        echo "<td class='text-center'>".$no."</td>";
                        echo "<td class='text-center'>".$row['invoice_id']."</td>";
                        echo "<td class='text-center'>".explode(' ',$row['invoice_date'])[0]."</td>";
                        echo "<td class='text-center'>".$servicename."</td>";
            						echo "<td class='text-center'>".$row['total_spend']."</td>";
                        echo "<td class='text-center'>".number_format($total_points,2)."</td>";
                        echo "<td class='text-center'>".$ops1."</td>";
                        echo "<td class='text-center'>".$ops2."</td>";
                        echo "</tr>";
                        
                        $no++;
                    }
                }

                ?>
              </tbody>
            </table>
			<?php } ?>
          </div>
        </div>
      </div>
      <!-- END REPORT COLUMN -->
    </div>
  </div>
</div>

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
<!--/page content-->
<!-- content container ends -->
</body>
</html>
