<?php
require_once './../util/initialize.php';
include 'common/upper_content.php';
$branch_id = '';
if(isset($_POST['branch_id'])){
  $branch_id = $_POST['branch_id'];
}


$total_cash = 0;
$payment_cash = Invoice::get_invoice_by_branch_amount_cash($branch_id);
if($payment_cash){
  $total_cash = $payment_cash;
}else{
  $total_cash = 0;
}
$total_e = 0;
$payment_e = Invoice::get_invoice_by_branch_amount_e($branch_id);
if($payment_e){
  $total_e = $payment_e;
}else{
  $total_e = 0;
}
$total_credit = 0;
$payment_credit = Invoice::get_invoice_by_branch_amount_credit($branch_id);
if($payment_credit){
  $total_credit = $payment_credit;
}else{
  $total_credit = 0;
}

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
    <div class="page-title">
      <div class="title_left">
        <h3 style="font-weight:800;">Invoice Payment Report</h3>
      </div>

      <div class="title_right">

      </div>
    </div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2 id="title" style="font-weight:700;"> Invoice Payment Report</h2>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <!-- form start -->
              <form class="form-inline" method="post" action="invoice_payment.php">
                <div class="form-group">
                  <div>
                    <label for="search_branch">Branch</label>  
                  </div>
                  <div>
                    <select class="form-control" name="branch_id" id="branch_id">
                    <option value="">Select Branch</option>
                    <?php
                      
                      foreach(Branch::find_all() as $branch){
                      $selected = '';
                      if(isset($branch_id) && $branch_id == $branch->id){
                        $selected = "selected";
                      } 
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
                <div class="form-group" style="float:right;">
                    <?php if($branch_id){?>
                    <button class="btn btn-primary" onclick="exportTableToExcel('tblData')" style="margin-top:20px;">Export Table Data To Excel File</button>
                    <?php } ?>
                </div>

              </form>
              <p style="color:red; margin-top:10px"><?php if(isset($error)) echo $error;?></p>
              
              <!-- form ends -->
            </div>
          </div>
        </div>
      </div>
      <div class="clearfix"></div>
      <?php Functions::output_result(); ?>
    </div>
    <?php if($branch_id){?>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
          <table id="tblData" class="table table-bordered" style="font-size:10px;width:100%;">  
            <thead>
              <tr>
                <th>Branch</th>
                <th>Payment Type</th>
                <th>Total Payment</th>
              </tr>
            </thead>
            <tbody>

              <?php
         
              $user = Branch::find_by_id($branch_id);
              // start table body
              echo "<tr>";
              echo "<td>".$user->name."</td>";
              echo "<td>".'Cash'."</td>";
              echo "<td>".$total_cash."</td>";
              echo "</tr>";

              echo "<tr>";
              echo "<td>".$user->name."</td>";
              echo "<td>".'E-Payment'."</td>";
              echo "<td>".$total_e."</td>";
              echo "</tr>";

              echo "<tr>";
              echo "<td>".$user->name."</td>";
              echo "<td>".'Credit Card'."</td>";
              echo "<td>".$total_credit."</td>";
              echo "</tr>";
              // end table body
              ?>

            </tbody>
          </table>
          </div>
      </div>
    </div>
    <?php }?>
</div>
</div>
<!--/page content-->
<?php include 'common/bottom_content.php'; ?> bottom content

