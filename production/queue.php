<?php
require_once './../util/initialize.php';
require_once 'common/pos_header.php';
$user = User::find_by_id($_SESSION["user"]["id"]);
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

          <ul class="nav nav-tabs">
            <li class="active" style="width:200px;"><a data-toggle="tab" href="#home"> <b style="font-size:20px;"> QUEUE <br/> <?php echo date("Y-m-d"); ?></b></a></li>
          </ul>

          <div class="tab-content">

            <div id="home" class="tab-pane fade in active">
              <h3>DAILY QUEUE</h3>

              <!-- form start -->
              <form class="form-horizontal" action="proccess/queue_process.php" method="post">
                <div class="form-group">
                  <label class="control-label col-sm-2" for="email"> Customer Name: </label>
                  <div class="col-sm-10">
                    <select class="form-control selectpicker"  data-live-search="true" name="customer_id">
                      <?php
                      foreach(Customer::find_all() as $customer_data){
                        echo "<option value='".$customer_data->id."'>".$customer_data->full_name." - ".$customer_data->mobile." - ".$customer_data->email."</option>";
                      }
                      ?>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-2" for="email"> Queue Type: </label>
                  <div class="col-sm-10">
                    <select class="form-control selectpicker"  data-live-search="true" name="queue_type">
                      <option value='creative'> Creative </option>
                      <option value='stylist'> Stylist </option>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" name="save"  class="btn btn-info" style="padding-top:15px;padding-bottom:15px;font-size:25px;" >- GENERATE -</button>

                  </div>
                </div>
              </form>
              <!-- form ends -->
            </div>

            <div id="home" class="tab-pane fade in active">
              <h3> - QUEUE STATUS - </h3>

              <!-- queue status start -->

              <?php
              $today_date = date("Y-m-d");
              foreach(Queue::find_all_today_branch($today_date,$user->branch_id) as $queue_data){
                ?>
                <div class="col-sm-2" style="padding:5px;text-align:center;">
                  <div class="col-sm-12" style="<?php if($queue_data->queue_type == 'creative'){ echo "background-color:#81ecec;";}else if($queue_data->queue_type == 'stylist'){echo "background-color:#81ecec;";}else if($queue_data->queue_type == 'online'){echo "background-color:#81ecec;";} ?>border-radius:10px;color:black; padding-bottom:5px;box-shadow: 5px 10px 10px #2d3436;">
                    <b style="color:orange;font-size:22px;"><?php echo $queue_data->queue_number; ?></b>
                    <p>Customer Name: <br/><b style="color:#0984e3;"><?php echo $queue_data->customer_id()->full_name; ?></b></p>
                    <p>Appoinment Type: <br/><b style="color:#0984e3;"><?php echo $queue_data->queue_type; ?></b></p>
                    <p>Status: <br/><b style="color:#0984e3;"><?php
                    if($queue_data->status == 0){
                      echo "UNALLOCATED<br/>";
                      ?>
                      <a href="proccess/queue_process.php?allocate=<?php echo $queue_data->id; ?>" class="btn btn-info btn-xs" role="button"> - ALLOCATED -</a>
                      <a href="proccess/queue_process.php?discard=<?php echo $queue_data->id; ?>" class="btn btn-danger btn-xs" role="button"> - DISCARD -</a>

                      <?php
                    }else if($queue_data->status == 1){
                      echo "ALLOCATED<br/>";
                      ?>
                      <a href="proccess/invoice_process.php?customer_id=<?php echo $queue_data->customer_id; ?>" class="btn btn-warning btn-xs btn-block" role="button"> - INVOICE - </a>
                      <br/>
                      <a href="proccess/queue_process.php?done=<?php echo $queue_data->id; ?>" class="btn btn-success btn-xs" role="button"> - DONE -</a>
                      <a href="proccess/queue_process.php?discard=<?php echo $queue_data->id; ?>" class="btn btn-danger btn-xs" role="button"> - DISCARD -</a>

                      <?php
                    }else if($queue_data->status == 2){
                      echo "DONE<br/>";
                      ?>
                      <a href="proccess/queue_process.php?done=<?php echo $queue_data->id; ?>" class="btn btn-success btn-xs" role="button"> - DONE -</a>

                      <?php
                    }else if($queue_data->status == 3){
                      echo "<b style='font-weight:700;color:red;'>DISCARDED</b><br/>";
                      ?>

                      <?php
                    }
                    ?>

                  </b></p>

                  <p><b style="color:blue;"><?php echo $queue_data->que_date_time; ?></b></p>

                  </div>
                </div>
                <?php
              }

              ?>

              <!-- queue status ends -->

            </div>



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
