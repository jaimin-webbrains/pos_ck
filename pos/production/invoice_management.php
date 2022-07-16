<?php
require_once './../util/initialize.php';
require_once 'common/pos_header.php';
$user = User::find_by_id($_SESSION["user"]["id"]);
// session_start();
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
              $branch = Branch::find_by_id($user->branch_id);
              echo $branch->name;
              ?> || Code: <?php
              $branch = Branch::find_by_id($user->branch_id);
              echo $branch->code;
              ?></td>
            </tr>
        </tbody>
      </table>

    </div>

    <?php require_once 'common/mini_header.php'; ?>

  </div>
</div>


<div class="container-fluid">
  <div class="row">

    <div class="col-sm-12">
      <div class="col-sm-12" id='bottom-section'>

        <?php Functions::output_result(); ?>

        <!-- invoice type selector -->
        <form class="form-inline" method="post" action="invoice_management.php">
          <div class="form-group">
            <label for="from_date">From Date:</label><br/>
            <input type="date" class="form-control" name="from_date">
          </div>
          <div class="form-group">
            <label for="to_date">To Date:</label><br/>
            <input type="date" class="form-control" name="to_date">
          </div>
          <div class="form-group">
            <br/>
            <button type="submit" class="btn btn-primary" name="find_bydate">FIND</button>
          </div> 
          <div class="form-group">
            
          </div>
          <div class="form-group ">
            <label for="invoice_number_name">Invoice Number:</label><br/>
            <input type="text" class="form-control" name="invoice_number_name">
          </div>
          <div class="form-group">
            <br/>
            <button type="submit" name="invoice" class="btn btn-primary">FIND</button>
          </div>
        </form>

        <?php 
          
          if(isset($_POST['from_date']) && isset($_POST['to_date'])){
            $diff=date_diff(date_create($_POST['from_date']),date_create($_POST['to_date']));
            $report_desc = "(".$_POST['from_date']." to ".$_POST['to_date'].")";
            $_SESSION["from_date"] = $_POST['from_date'];
            $_SESSION["to_date"] = $_POST['to_date'];
          }
          if(isset($_POST['invoice_number_name'])){
            $report_desc = $_POST['invoice_number_name'];
            $report_desc = isset($_POST['invoice_number_name']) ? $_POST['invoice_number_name']: '';
          }
        ?>
        <?php if(isset($report_desc)){ ?>
        <h2 id="title" style="font-weight:700;"><?php echo $report_desc?></h2>
        <?php } ?>
        <table class="table">
          <thead>
            <tr>
              <th>Invoice Number</th>
              <th>Invoice Date</th>
              <th>Customer Name</th>
              <th style='text-align:center;'>Invoice Branch</th>
              <th style='text-align:right;'>OPS1 COUNT</th>
              <th style='text-align:right;'>OPS1 COUNT</th>
              <th style='text-align:right;'>HEAD COUNT</th>

              <th style='text-align:right;'></th>
              <th style='text-align:right;'></th>
            </tr>
          </thead>
          <tbody>
            <?php

            $invoice_number_name = isset($_POST['invoice_number_name']) ? $_POST['invoice_number_name']: '';
            $from_date = isset($_SESSION["from_date"]) ? $_SESSION["from_date"]: '';
            $to_date = isset($_SESSION["to_date"]) ? $_SESSION["to_date"]: '';
            $total_records = Invoice::row_count_invoice($from_date,$to_date,$branch->id);
            
            $pagination = new Pagination($total_records);
            
            $objects = Invoice::find_all_by_limit_offset_invoice($pagination->records_per_page, $pagination->offset(), $from_date,$to_date, $invoice_number_name, $branch->id);

            // echo '<pre>';
            // print_r($objects);
            // die;

            foreach($objects as $invoice_data){
                $user_branchname = $invoice_data->invoice_branch()->name;

                echo "<tr>";
                echo "<td>".$invoice_data->invoice_number."</td>";
                echo "<td>".$invoice_data->invoice_date."</td>";
                echo "<td>".$invoice_data->customer_id()->full_name."</td>";
                echo "<td style='text-align:center;'>".$invoice_data->invoice_branch()->name."</td>";

                $head_count = 1;
                // Headcount start
                foreach(InvoiceSub::find_all_invoice_id($invoice_data->id) as $sub_invoice_data){
                  if( $sub_invoice_data->ops2 > 0 ){
                    $head_count = 0.5;
                  }
                }
                // Headcount end
                if($head_count == 1){
                  echo "<td style='text-align:right;'> 1 </td>";
                  echo "<td style='text-align:right;'> 0 </td>";
                }else{
                  echo "<td style='text-align:right;'> 0.5 </td>";
                  echo "<td style='text-align:right;'> 0.5 </td>";
                }
                echo "<td style='text-align:right;'><a href='invoice_print.php?invoice_id=".$invoice_data->id."' target='_blank' class='btn btn-xs btn-success'>PRINT</a>
                <a href='invoice_sub_management.php?invoice_id=".$invoice_data->id."' class='btn btn-xs btn-primary'>VIEW</a>
                </td>";
                if(Functions::check_privilege_by_module_action("POS_Invoice","del")){
                  echo "<td style='text-align:left;'><a href='proccess/index_process.php?inv_delete=".$invoice_data->id."' class='btn btn-danger btn-xs b1'> Delete </a></td>";
                }
                
                echo "</tr>";
            }
            ?>
          </tbody>
        </table>

        <div onclick="window.location.href:''" class="x_content">
          <?php
         echo $pagination->get_pagination_links_html1("invoice_management.php");
          ?>
        </div>
        <!-- end of invoice type selector -->
      </div>
    </div>

  </div>
</div>

</form>

<!-- content container ends -->
</body>
</html>
