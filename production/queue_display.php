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
              <h3> - QUEUE DETAILS -  <a href="index.php" class="btn btn-primary" style="font-weight:700;"> DONE </a></h3>

              <!-- Queue details start -->
              <?php
              $queue_generated_data = Queue::find_by_id($_GET['queue_details']);
              ?>
              <hr/>
              <div class="col-sm-12" style="font-size:30px;">
                <p> Customer Name:  <?php echo $queue_generated_data->customer_id()->full_name; ?></p>
                <p> Queue Type:  <?php echo $queue_generated_data->queue_type; ?></p>
                <p> Queue Number:  <?php echo $queue_generated_data->queue_number; ?></p>
                <p> Queue Date:  <?php echo $queue_generated_data->que_date_time; ?></p>
              </div>
              <!-- Queue details ends -->
              <div class="row">
                <div class="col-sm-12">
                  <form action="queue_display.php" method="post" >
                    <input type="hidden" name="id" value="<?php echo $queue_generated_data->id ?>"/>
                    <a href='queue_display_print.php?id=<?php echo $queue_generated_data->id ?>' style="font-size:21px;font-weight:700;" class='btn btn-success btn-block' target='_blank'>Queue Print</a>
                  </form>
                </div>
              </div>

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
