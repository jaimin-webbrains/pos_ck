<?php
require_once './../util/initialize.php';
require_once 'common/pos_header.php';
$user = User::find_by_id($_SESSION["user"]["id"]);
?>
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
        <div class="col-sm-12" style="padding-top:30px;">
          <?php
          if(Functions::check_privilege_by_module_action("POS_Invoice","ins")){
            ?>
            <div class="col-sm-2"> <a href="invoice_type.php"><img src="uploads/logos/1-04-01.png" style="width:100%;"></a> </div>
          <?php } ?>
          <?php
          if(Functions::check_privilege_by_module_action("POS_Customer","ins")){
            ?>
            <div class="col-sm-2"> <a href="customer.php"><img src="uploads/logos/1-04-02.png" style="width:100%;"></a> </div>
          <?php } ?>
          <?php
          if(Functions::check_privilege_by_module_action("POS_Invoice","view")){
            ?>
            <div class="col-sm-2"> <a href="invoice_management.php"><img src="uploads/logos/1-04-03.png" style="width:100%;"></a> </div>
          <?php } ?>
          <div class="col-sm-2"> <a href="redemption_check.php"><img src="uploads/logos/1-04-04.png" style="width:100%;"></a> </div>
          <div class="col-sm-2"> <a href="reward_point.php"><img src="uploads/logos/1-04-05.png" style="width:100%;"></a> </div>
          <?php
          if(Functions::check_privilege_by_module_action("POS_Queue","ins")){
            ?>
            <div class="col-sm-2"> <a href="queue.php"><img src="uploads/logos/6-01.png" style="width:100%;"></a> </div>
          <?php } ?>

        </div>



      </div>

    </div>
  </div>
  <div class="container-fluid" style="margin-top:20px;">
    <div class="col-sm-12 pending-grid">
      <a href="daily_summary.php" class="btn btn-primary btn-block" target="_blank" style="background-color:#34495e;font-size:20px;font-weight:700;">DAILY SUMMARY REPORT</a>
      <hr/>
      <div class="col-sm-6">
        <label style="font-size:20px;">PENDING INVOICES</label><br/>
        <?php
        foreach(Invoice::find_all_pending($user->branch_id) as $pending_invoices){
          ?>
          <div class="col-sm-6" style="padding:5px;">
            <div class="col-sm-12" style="background-color:#2c3e50;padding:5px;border-radius:5px;">
              <?php
              echo "Invoice : ".$pending_invoices->invoice_number;
              echo " / Customer Name :".$pending_invoices->customer_id()->full_name;
              ?>
              <br/>
              <?php
              if(Functions::check_privilege_by_module_action("POS_Invoice","upd")){
                ?>
                <a href="invoice.php?invoice_id=<?php echo $pending_invoices->id; ?>" class="btn btn-primary btn-xs b1"> Edit </a>
              <?php } ?>
              <?php
              if(Functions::check_privilege_by_module_action("POS_Invoice","del")){
                ?>
                <a href="proccess/index_process.php?inv_delete=<?php echo $pending_invoices->id; ?>" class="btn btn-danger btn-xs b1"> Discard </a>
              <?php } ?>

            </div>

          </div>
          <?php
        }
          ?>
      </div>
      <div class="col-sm-6">
        <label style="font-size:20px;">PENDING QUEUE</label> <a href="running_queue.php" class="btn btn-success btn-xs" target="_blank" > RUNNING QUEUE </a><br/>
        <?php
        $today_date = date("Y-m-d");
        foreach(Queue::find_all_today_branch($today_date,$user->branch_id) as $queue_data){
          ?>
          <div class="col-sm-6" style="padding:5px;">
            <div class="col-sm-12" style="background-color:#2c3e50;padding:5px;border-radius:5px;">
              [ <?php echo $queue_data->queue_number; ?> ]
              Customer Name: <b style="color:orange;"><?php echo $queue_data->customer_id()->full_name; ?></b>
              / Appoinment Type: <b style="color:orange;"><?php echo $queue_data->queue_type; ?></b>

              <?php
              if($queue_data->status == 0){
                echo "UNALLOCATED<br/>";
                ?>
                <a href="proccess/queue_process.php?allocate=<?php echo $queue_data->id; ?>" class="btn btn-info btn-xs" role="button"> - ALLOCATE -</a>
                <a href="proccess/queue_process.php?discard=<?php echo $queue_data->id; ?>" class="btn btn-danger btn-xs" role="button"> - DISCARD -</a>

                <?php
              }else if($queue_data->status == 1){
                echo "ALLOCATED<br/>";
                ?>
                <a href="proccess/queue_process.php?done=<?php echo $queue_data->id; ?>" class="btn btn-warning btn-xs btn-block" role="button"> - INVOICE -</a>
                <br/>
                <a href="proccess/queue_process.php?done=<?php echo $queue_data->id; ?>" class="btn btn-success btn-xs" role="button"> - DONE -</a>
                <a href="proccess/queue_process.php?discard=<?php echo $queue_data->id; ?>" class="btn btn-danger btn-xs" role="button"> - DISCARD -</a>

                <?php
              }else if($queue_data->status == 2){
                echo "<br/>DONE<br/>";

              }else if($queue_data->status == 3){
                echo "<b style='font-weight:700;color:red;'>DISCARDED</b><br/>";
                ?>

                <?php
              }
              ?>
            </div>

          </div>
          <?php
        }
          ?>
      </div>

    </div>
  </div>



</form>
<!-- content container ends -->
</body>
</html>
