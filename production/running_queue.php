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

  <div class="container-fluid" style="margin-top:20px;">
    <!-- LEFT LAYER -->
    <div class="col-sm-12 pending-grid">

      <div class="col-sm-7" style="padding:10px;">

        <!-- PENDIG START -->
        <div class="col-sm-12">
          <label> - CREATIVE QUEUE - </label>
          <br/>
          <?php
          $today_date = date("Y-m-d");
          foreach(Queue::find_all_today_branch_pending_creative($today_date,$user->branch_id) as $queue_data){
            ?>
            <div class="col-sm-6" style="padding:5px;">
              <div class="col-sm-12" style="background-color:#3c6382;padding:5px;border-radius:5px;height:130px;">
                <b style="font-size:30px;">[ <?php echo $queue_data->queue_number; ?> ]</b>
                <br/>
                <b style="color:orange;font-size:20px;"><?php echo $queue_data->customer_id()->full_name; ?></b>
                <br/>
                <b style="color:#dfe6e9;"><?php echo $queue_data->queue_type; ?></b>
                <br/>
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


        <div class="col-sm-12">
          <label> - STYLIST QUEUE - </label>
          <br/>
          <?php
          $today_date = date("Y-m-d");
          foreach(Queue::find_all_today_branch_pending_stylist($today_date,$user->branch_id) as $queue_data){
            ?>
            <div class="col-sm-6" style="padding:5px;">
              <div class="col-sm-12" style="background-color:#1e3799;padding:5px;border-radius:5px;">
                <b style="font-size:30px;">[ <?php echo $queue_data->queue_number; ?> ]</b>
                <br/>
                <b style="color:orange;font-size:20px;"><?php echo $queue_data->customer_id()->full_name; ?></b>
                <br/>
                <b style="color:#dfe6e9;"><?php echo $queue_data->queue_type; ?></b>
                <br/>
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


        <div class="col-sm-12">
          <label> - ONLINE QUEUE - </label>
          <br/>
          <?php
          $today_date = date("Y-m-d");
          foreach(Queue::find_all_today_branch_pending_online($today_date,$user->branch_id) as $queue_data){
            ?>
            <div class="col-sm-6" style="padding:5px;">
              <div class="col-sm-12" style="background-color:#182C61;padding:5px;border-radius:5px;">
                <b style="font-size:30px;">[ <?php echo $queue_data->queue_number; ?> ]</b>
                <br/>
                <b style="color:orange;font-size:20px;"><?php echo $queue_data->customer_id()->full_name; ?></b>
                <br/>
                <b style="color:#dfe6e9;"><?php echo $queue_data->queue_type; ?></b>
                <br/>
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
      <div class="col-sm-5" style="padding:10px;">

        <div class="row">
          <?php
          $videodata = Advertisment::find_last_advertisment_video();
          ?>
          <!-- video start -->
          <video width="500px" autoplay loop muted>
            <source src="./../../production/uploads/advertisment/<?php echo $videodata->content; ?>" type="video/mp4">
            </video>
            <!-- video ends -->
          </div>
          <div class="row">

            <div id="myCarousel" class="carousel slide" data-ride="carousel">

              <!-- Wrapper for slides -->
              <div class="carousel-inner">

                <?php
                $count = 1;
                foreach (Advertisment::find_all_by_images() as $images) {
                  ?>
                  <div class="item <?php if($count == 1){ echo "active"; ++$count; } ?>">
                    <img src="./../../production/uploads/advertisment/<?php echo $images->content; ?>" style="width:500px;" />
                  </div>
                  <?php
                }
                ?>

              </div>

            </div>

          </div>

        </div>

        <div class="col-sm-12">
          <!-- NEWS TICKER START -->
          <div class="col-sm-12" style="background-color:#e74c3c;font-size:20px;">
            <marquee class="scroll-text" direction="left">
              <?php
              foreach (NewsTicker::find_last_five() as $news) {
                echo $news->content.str_repeat("&nbsp;", 8); ;
                //echo '<span class="glyphicon glyphicon-forward"></span> | <span class="glyphicon glyphicon-forward"></span>';
              }
              ?>
            </marquee>

          </div>
          <!-- NEWS TICKER ENDS -->
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
