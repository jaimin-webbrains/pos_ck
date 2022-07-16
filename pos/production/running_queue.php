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
  /* background-color: teal; */
  margin: 5px;
  text-align: left;
  color:white;
  padding: 10px;
  /* box-shadow: 5px 10px 10px #636e72; */
}
</style>
<body class="running-page">
  <!-- content container starts -->

  <div class="container-fluid">
    <!-- LEFT LAYER -->
    <div class="pending-grid">
      <div class="row">
        <div class="col-md-8 left-three-boxes">
          <div class="row">
            <!-- PENDIG START -->
            <div class="col-sm-4">
              <h4 class="boxes-title">CREATIVE QUEUE</h4>
              <?php
              $today_date = date("Y-m-d");
              foreach(Queue::find_all_today_branch_pending_creative($today_date,$user->branch_id) as $queue_data){
                ?>
                <div class="three-boxes">
                    <p class="cust-number">[ <?php echo $queue_data->queue_number; ?> ]</p>
                    <p class="cust-name"><?php echo $queue_data->customer_id()->full_name; ?></p>
                    <p class="cust-type"><?php echo $queue_data->queue_type; ?></p>
                    <?php
                    if($queue_data->status == 0){
                      echo "UNALLOCATED<br/>";
                      ?>
                      <?php
                    }else if($queue_data->status == 1){
                      echo $queue_data->allocated_date_time."<br/>";
                    }
                    ?>
                </div>
                <?php
              }
              ?>
            </div>

            <div class="col-sm-4">
              <h4 class="boxes-title">STYLIST QUEUE</h4>
              <?php
              $today_date = date("Y-m-d");
              foreach(Queue::find_all_today_branch_pending_stylist($today_date,$user->branch_id) as $queue_data){
                ?>
                <div class="three-boxes">
                  <p class="cust-number">[ <?php echo $queue_data->queue_number; ?> ]</p>
                  <p class="cust-name"><?php echo $queue_data->customer_id()->full_name; ?></p>
                  <p class="cust-type"><?php echo $queue_data->queue_type; ?></p>
                    <?php
                    if($queue_data->status == 0){
                      echo "UNALLOCATED<br/>";
                      ?>
                      <?php
                    }else if($queue_data->status == 1){
                      echo $queue_data->allocated_date_time."<br/>";
                    }
                    ?>
                </div>
                <?php
              }
              ?>
            </div>

            <div class="col-sm-4">
              <h4 class="boxes-title">ONLINE QUEUE</h4>
              <?php
              $today_date = date("Y-m-d");
              foreach(Queue::find_all_today_branch_pending_online($today_date,$user->branch_id) as $queue_data){
                ?>
                <div class="three-boxes">
                  <div class="col-sm-12" style="background-color:#182C61;padding:5px;border-radius:5px;">
                  <p class="cust-number">[ <?php echo $queue_data->queue_number; ?> ]</p>
                  <p class="cust-name"><?php echo $queue_data->customer_id()->full_name; ?></p>
                  <p class="cust-type"><?php echo $queue_data->queue_type; ?></p>
                    <?php
                    if($queue_data->status == 0){
                      echo "UNALLOCATED<br/>";
                      ?>
                      <?php
                    }else if($queue_data->status == 1){
                      echo $queue_data->allocated_date_time."<br/>";
                    }
                    ?>

                  </div>
                </div>
                <?php
              }
              ?>
            </div>
            <!-- PEND ENDS -->
          </div>
        </div>

        <div class="col-md-4 text-right">
          <div class="row">
            <div class="col-sm-6 col-md-12">
              <div class="right-video">
                <?php
                $videodata = Advertisment::find_last_advertisment_video();
                ?>
                  <!-- video start -->
                  <video width="100%" autoplay loop muted>
                    <source src="./../../production/uploads/advertisment/<?php echo $videodata->content; ?>" type="video/mp4">
                  </video>
                  <!-- video ends -->
              </div>
            </div>
            
            <div class="col-sm-6 col-md-12">
              <div class="right-video">
                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                  <!-- Wrapper for slides -->
                  <div class="carousel-inner">
                    <?php
                    $count = 1;
                    foreach (Advertisment::find_all_by_images() as $images) {
                      ?>
                      <div class="item <?php if($count == 1){ echo "active"; ++$count; } ?>">
                        <img src="./../../production/uploads/advertisment/<?php echo $images->content; ?>" class="img-responsive" />
                      </div>
                        <?php
                      }
                      ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
          </div>

          <!-- <div class="col-sm-12">
            <div class="col-sm-12" style="background-color:#e74c3c;font-size:20px;">
              <marquee class="scroll-text" direction="left">
                <?php
                foreach (NewsTicker::find_last_five() as $news) {
                  echo $news->content.str_repeat("&nbsp;", 8); ;
                }
                ?>
              </marquee>

            </div>
          </div> -->

        </div>

      </div>
    </div>



  </form>
  <!-- content container ends -->
</body>
<script type="text/javascript">

$( document ).ready(function() {
  // setTimeout(function() {
  //   location.reload();
  // }, 5000);
});

</script>
</html>
