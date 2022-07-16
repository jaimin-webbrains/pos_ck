<?php
require_once './../util/initialize.php';
include 'common/upper_content.php';
$con=mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
?>

<!--page content-->
<div class="right_col" role="main">
  <div class="">
    <?php Functions::output_result(); ?>
    <div class="row">

      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2 id="title" style="font-weight:700;"> - CUSTOMER TOTAL SPEND REPORT - (Year)</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <form class="form-inline" method="post" action="customer_total_spend_report.php">
              <div class="form-group" style="margin-right:30px;">
                <div>
                  <label for="contact_email">All Branches</label>  
                </div>
                <div>
                  <input type="radio" name="allbranches" id="allbranches_all_3" value="all" checked/>
                  <label for="allbranches_all_3">Yes</label>
                  <input type="radio" name="allbranches" id="allbranches_one_3" value="one" style="margin-left:30px;"/>
                  <label for="allbranches_one_3">No</label>
                </div>
              </div>

              <div class="form-group" style="margin-right:30px;">
                <div>
                  <label for="search_branch">Branch</label>  
                </div>
                <div>
                  <select class="form-control" name="branch_id" id="branch_id_3">
                  <?php
                    foreach(Branch::find_all() as $branch){
                      echo "<option value='".$branch->id."' $selected>".$branch->name."</option>";
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
          <div class="x_title">
            <?php
              
            
            ?>
            <h2 id="title" style="font-weight:700;">Report <?php //echo $report_desc?></h2>
            <button class="btn btn-primary" style="float:right" onclick="exportTableToExcel('report_table')">Export Table</button>
            <div class="clearfix"></div>
          </div>
          <div class="x_content" style="overflow-x:auto;">
            <!-- table start -->
            
            <table class="table table-bordered" id="report_table">
              <thead>
                <tr>
                  <th style='text-align:center;'>No.</th>
                  <th style='text-align:center;'>Name</th>
                  <th style='text-align:center;'>Tel No.</th>
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
                if(isset($_POST['branch_id'])){
                $branch_id = $_POST['branch_id'];
                }
                if($branch_id != NULL){
                    $branch_condition = "WHERE invoice_branch = $branch_id ";
                }

                $sql = "SELECT invoice.id as invoice_id,SUM(invoice_payment) as total_spend,customer.*  FROM invoice JOIN customer on invoice.customer_id = customer.id ".$branch_condition." group by customer_id ORDER BY total_spend desc"; 
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
                        echo "<td>".$no."</td>";
                        echo "<td>".$row['full_name']."</td>";
                        echo "<td>".$row['mobile']."</td>";
                        echo "<td>".$row['total_spend']."</td>";
                        echo "<td>".number_format($total_points,2)."</td>";
                        echo "</tr>";
                        $no++;
                        $total_spend += $row['total_spend'];
                        $points_total += $total_points;
                    }
                }

                ?>
                <tr>
                    <td style="font-weight: bold;">Total</td>
                    <td ></td>
                    <td ></td>
                    <td style="font-weight: bold;"><?php echo $total_spend?></td>
                    <td style="font-weight: bold;"><?php echo $points_total?></td>
                </tr>
              </tbody>
            </table>
            <!-- table ends -->
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
<script>
  $(document).ready( function () {
    $('#branch_id').attr("disabled", "true");
    $('#branch_id_2').attr("disabled", "true");
    $('#branch_id_3').attr("disabled", "true");

    $("#allbranches_all").click(() => {
      $('#branch_id').attr("disabled", "true");
    });
    $("#allbranches_one").click(() => {
      $('#branch_id').removeAttr("disabled");
    });

    $("#allbranches_all_2").click(() => {
      $('#branch_id_2').attr("disabled", "true");
    });
    $("#allbranches_one_2").click(() => {
      $('#branch_id_2').removeAttr("disabled");
    });

    $("#allbranches_all_3").click(() => {
      $('#branch_id_3').attr("disabled", "true");
    });
    $("#allbranches_one_3").click(() => {
      $('#branch_id_3').removeAttr("disabled");
    });

    $('#report_table').DataTable({
      "lengthMenu": [[50, 100, -1], [50, 100, "All"]],
    });

  });
</script>
<!--/page content-->
<?php include 'common/bottom_content.php'; ?>
