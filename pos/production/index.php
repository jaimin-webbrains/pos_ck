<?php
require_once './../util/initialize.php';
require_once 'common/pos_header.php';
$user = User::find_by_id($_SESSION["user"]["id"]);
?>

<!-- default css -->
<link href="css/default.css" rel="stylesheet">
<style media="screen">
.b1{
  font-weight: 700;
}
.pending-grid{
  background-color: teal;
  margin: 5px;
  text-align: left;
  color:white;
  padding: 10px;
  box-shadow: 5px 10px 10px #636e72;
}
#info-bar {
    background-color: #103c49;
    box-shadow: none;
    padding: 5px 120px 5px;
    margin-top: 0;
    text-transform: inherit;
    margin-bottom: 0;
}
</style>
<body class="testcashier-page">
  <!-- content container starts -->
  <div class="container-fluid top-header">
    <div class="row" id='info-bar'>
      <div class="col-sm-8">
        <table class="table header-table">
          <tbody>
            <tr>
              <td>
                <p class="date"><?php echo date("l, F d Y"); ?></p>
                <p class="time"><?php echo date("h:i:a");?></p>
              </td>
              <td>LOGGEDIN USER: <?php echo $user->name; ?> || Branch Name: <?php
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

  <div class="pt-70">
    <div class="container-fluid">
      <h2 class="service-title">Services</h2>
      <div class="row">      
        <?php
        if(Functions::check_privilege_by_module_action("POS_Invoice","ins")){
          ?>
          <div class="col-lg-2 col-sm-4">
            <div class="services-single">
              <a href="invoice_type.php">
                <img src="images/services-icons1.png" class="img-responsive">
                <h4>Invoice</h4>
              </a>
            </div>
          </div>
        <?php } ?>
        <?php
        if(Functions::check_privilege_by_module_action("POS_Customer","ins")){
          ?>
          <div class="col-lg-2 col-sm-4">
            <div class="services-single">
              <a href="reward_point.php">
                <img src="images/services-icons2.png" class="img-responsive">
                <h4>Reward Point & Voucher</h4>
              </a>
            </div>
          </div>
        <?php } ?>
        <?php
        if(Functions::check_privilege_by_module_action("POS_Invoice","view")){
          ?>
          <div class="col-lg-2 col-sm-4">
            <div class="services-single">
              <a href="redemption_check.php">
                <img src="images/services-icons3.png" class="img-responsive">
                <h4><span class="d-block">Redemtion</span> Check</h4>
              </a>
            </div>
          </div>
        <?php } ?>
        <div class="col-lg-2 col-sm-4">
          <div class="services-single">
            <a href="invoice_management.php">
              <img src="images/services-icons4.png" class="img-responsive">
              <h4><span class="d-block">Invoice</span> History</h4>
            </a>
          </div>
        </div>
        <div class="col-lg-2 col-sm-4">
          <div class="services-single">
            <a href="customer.php">
              <img src="images/services-icons5.png" class="img-responsive">
              <h4><span class="d-block">New</span> Customer</h4>
            </a>
          </div>
        </div>
        <?php
        if(Functions::check_privilege_by_module_action("POS_Queue","ins")){
          ?>
          <div class="col-lg-2 col-sm-4">
            <div class="services-single">
              <a href="queue.php">
                <img src="images/services-icons6.png" class="img-responsive">
                <h4>Queue</h4>
              </a>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
    <div class="container-fluid">
      <div class="daily-summary-box">
        <a href="daily_summary.php" class="btn btn-primary btn-summary-report btn-block" target="_blank">DAILY SUMMARY REPORT</a>
        <a href="customer_past_transaction.php" class="btn btn-primary btn-summary-report btn-block" target="_blank">CUSTOMER PAST TRANSACTION</a>
        <div class="row">          
          <div class="col-md-6">
            <div class="pending-box">
              <h3 class="text-center">PENDING QUEUE</h3>
              <div class="text-center"><a href="running_queue.php" class="btn btn-success btn-running-queue" target="_blank" >RUNNING QUEUE</a></div>
              <p class="customer-name-status text-center">Customer name and Status</p>

              <div class="table-responsive">
                <table class="table table-striped daily-report-table">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Appointment Type</th>
                      <th colspan=3>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    $today_date = date("Y-m-d");
                    foreach(Queue::find_all_today_branch($today_date,$user->branch_id) as $queue_data){
                  ?>
                    <tr>
                      <td><?php echo $queue_data->customer_id()->full_name; ?></td>
                      <td><?php echo $queue_data->queue_type; ?></td>
                      <?php
                      if($queue_data->status == 0){
                        //echo "UNALLOCATED<br/>";
                        ?>
                        <td class="text-uppercase"><a href="proccess/queue_process.php?allocate=<?php echo $queue_data->id; ?>" class="btn btn-info btn-xs" role="button"> - ALLOCATE -</a></td>
                        <td class="text-uppercase"><a href="proccess/queue_process.php?discard=<?php echo $queue_data->id; ?>" class="btn btn-danger btn-xs" role="button"> - DISCARD -</a></td>

                        <?php
                      }else if($queue_data->status == 1){
                        echo "ALLOCATED<br/>";
                        ?>
                        <td class="text-uppercase"><a href="proccess/queue_process.php?done=<?php echo $queue_data->id; ?>" class="btn btn-warning btn-xs btn-block" role="button"> - INVOICE -</a></td>
                        <br/>
                        <td class="text-uppercase" style="padding:0"><a href="proccess/queue_process.php?done=<?php echo $queue_data->id; ?>" class="btn btn-success btn-xs" role="button"> - DONE -</a></td>
                        <td class="text-uppercase"><a href="proccess/queue_process.php?discard=<?php echo $queue_data->id; ?>" class="btn btn-danger btn-xs" role="button"> - DISCARD -</a></td>

                        <?php
                      }else if($queue_data->status == 2){
                        echo " <td class='text-uppercase' colspan=3><a href='javascript:void(0)' class='btn btn-success btn-xs' role='button'> DONE </a></td>";

                      }else if($queue_data->status == 3){
                        echo "<td class=text-uppercase'><b style='font-weight:700;color:red;'>DISCARDED</td></b><br/>";
                        ?>

                        <?php
                      }
                      ?>
                    </tr>
                  <?php
                  }
                  ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="pending-box">
              <h3 class="text-center">PENDING INVOICES</h3>
              <!-- <div class="text-center"><a href="#" class="btn-invoice">Invoice: IC000001 / Customer Name: Adrian Lim</a></div> -->
              <p class="customer-name-status text-center">Customer name and Status</p>

              <div class="table-responsive">
                <table class="table table-striped daily-report-table">
                  <thead>
                    <tr>
                      <th>Invoice</th>
                      <th>Customer Name</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    foreach(Invoice::find_all_pending($user->branch_id) as $pending_invoices){
                  ?>
                    <tr>
                      <td><?php echo $pending_invoices->invoice_number; ?></td>
                      <td><?php echo $pending_invoices->customer_id()->full_name; ?></td>
                      <td>
                      <?php
                      if(Functions::check_privilege_by_module_action("POS_Invoice","upd")){
                        ?>
                        <a href="invoice.php?invoice_id=<?php echo $pending_invoices->id; ?>" class="btn btn-primary btn-xs b1"> Edit </a>
                      <?php } ?>
                      <?php
                      if(Functions::check_privilege_by_module_action("POS_Invoice","del")){
                        ?>
                        <a href="proccess/index_process.php?inv_delete=<?php echo $pending_invoices->id; ?>" class="btn btn-danger b1"> Discard </a>
                      <?php } ?>
                      </td>
                    </tr>
                    <?php
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
<!-- content container ends -->
</body>
</html>
