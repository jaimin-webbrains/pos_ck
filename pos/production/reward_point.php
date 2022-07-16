<?php
require_once './../util/initialize.php';
require_once 'common/pos_header.php';
$user = User::find_by_id($_SESSION["user"]["id"]);
?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
        <div class="col-sm-6" id='bottom-section' style="min-height:300px;">

          <!-- form start -->
          <div class="col-sm-12" style="text-align:center;padding-bottom:30px;font-size:40px;">
            - REWARD POINT -
          </div>
          <div class="col-sm-12">
            <form class="form-horizontal" action="reward_point.php" method="post">

              <div class="form-group">
                <label class="control-label col-sm-2" for="email">Customer:</label>
                <div class="col-sm-10">
                  <select name="customer" class="form-control customer_select" data-live-search="true">
                    <option value="">Select</option>
                    <?php
                    // foreach( Customer::find_all() as $customer_data ){
                    //   echo "<option value='".$customer_data->id."'>".$customer_data->full_name." - ".$customer_data->mobile." - ".$customer_data->email."</option>";
                    // }
                    ?>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" name="save" class="btn btn-primary btn-block" style="font-weight:700;"> - CHECK - </button>
                </div>
              </div>
            </form>
          </div>

          <!-- form ends -->

        </div>

        <div class="col-sm-6" id='bottom-section' style="min-height:300px;">

          <!-- form start -->
          <div class="col-sm-12" style="text-align:center;padding-bottom:30px;font-size:20px;">
            - POINTS -
          </div>
         <p style='color:#e74c3c;'> *MINIMIUM VOUCHER VALUE IS <u>50 POINTS</u> </p>
          <div class="col-sm-12" style="font-size:19px;">
            <?php

			 $system_settings_value = SystemSettings::find_by_id(1);

  $system_min = $system_settings_value->min_voucher_point;

            if(isset($_POST['customer'])){
              echo Customer::find_by_id($_POST['customer'])->full_name;
              echo "<br/>";
              $cusid = $_POST['customer'];
              $points = 0;
              foreach(RewardPoint::find_all_by_customer_id($cusid) as $reward_data){
                $points = $points + $reward_data->reward_points;
              }
              echo "POINTS: ".$points."<hr/>";
              if( $points > 0 && $points > $system_min ){
                ?>
                <br/>

                <form action="voucher.php" method="post" target="_blank" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="email">Isuue Value ( POINTS ):</label>
                    <input type="hidden" name="cusid" value="<?php echo $cusid; ?>" class="form-control" id="email">

                    <input type="number" name="value" class="form-control" min="<?php echo  $system_min;?>" max="<?php echo $points; ?>" required>


                  </div>


				<div class="form-group">
                    <label for="img">Select Backgroung Image:</label><br>


					<input type="file" name="file1" class="form-control" required>
                  </div>
                  <button type="submit" class="btn btn-warning btn-lg">- ISSU A VOUCHER -</button>
                </form>



                <!-- <a href="voucher.php" class="btn btn-warning btn-lg"> - ISSU A VOUCHER - </a> -->
                <?php
              }else{
                ?>
                <br/>

                <!-- <form action="voucher.php" method="get" target="_blank">
                  <div class="form-group">
                    <label for="email">Voucher Value:</label>
                    <input type="hidden" name="cusid" value="<?php echo $cusid; ?>" class="form-control" id="email">
                    <input type="text" name="value" class="form-control" required>
                  </div>

                  <button type="submit" class="btn btn-warning btn-lg">- ISSU A VOUCHER -</button>
                </form> -->

                <!-- <a href="voucher.php?cusid=<?php echo $cusid; ?>" class="btn btn-warning btn-lg" target="_blank"> - ISSU A VOUCHER - </a> -->
                <!-- <button class="btn btn-warning btn-lg"> YOU NEED A MINIMUM OF 50 POUNTS TO GENERATE A VOUCHER </button> -->
                <?php
              }
            }
            ?>
          </div>

          <!-- form ends -->

        </div>

      </div>

    </div>
  </div>
</form>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$('.customer_select').select2({
    ajax: {
        url :"reward_point_check.php",
        dataType: "json",
        type: "GET",
        data: function (params) {
            var queryParameters = {
                search: params.term,
            }
            return queryParameters;
        },
        processResults: function (data, params) {
            params.page = params.page || 1;
            return {
                results: $.map(data, function (item) {
                  console.log(item);
                    return {
                        text: item.full_name + ' ' + item.mobile + ' ' + item.email,
                        id: item.id
                    }
                }),
                pagination: {
                    more: (params.page * 30) < data.total_count
                }
            };
        },
        cache: true,
    },
    placeholder: 'Select',
    minimumInputLength: 4
});
</script>
<!-- content container ends -->
</body>
</html>
