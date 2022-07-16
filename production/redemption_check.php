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
            <li class="active" style="width:200px;"><a data-toggle="tab" href="#home"> Customer </a></li>
          </ul>

          <div class="tab-content">

            <div id="home" class="tab-pane fade in active">
              <h3>REDEMPTION CHECK</h3>

              <!-- form start -->
              <form class="form-horizontal" action="redemption_check.php" method="post">
                <div class="form-group">
                  <input type="hidden" name="invoice_init" value="1" />
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
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit"  class="btn btn-info btn-block" style="padding-top:10px;padding-bottom:10px;font-size:25px;" >- CHECK -</button>
                    <!-- <a href="invoice.php" class="btn btn-info btn-block" style="padding-top:25px;padding-bottom:25px;font-size:25px;" role="button"> - Proceed - </a> -->

                  </div>
                </div>
              </form>
              <!-- form ends -->
            </div>



          </div>

          <!-- end of invoice type selector -->
        </div>

        <div class="col-sm-12" id='bottom-section'>

          <!-- table start -->

          <table class="table">
            <thead>
              <tr>
                <th>Customer Name</th>
                <th style='text-align:center;'>Package Name</th>
                <th style='text-align:center;'>Purchased Invoice</th>
                <th style='text-align:center;'>Purchased Qty</th>
                <th style='text-align:center;'>Available Balance</th>
              </tr>
            </thead>
            <tbody>

              <?php
              if(isset($_POST['customer_id'])){
              $customer_id = $_POST['customer_id'];
              $redeem_obj = Redeem::find_all_customer_id($customer_id);
              if(count($redeem_obj) > 0){
                foreach($redeem_obj as $redeem_data){
                  ?>
                  <tr>
                    <td><?php echo $redeem_data->customer_id()->full_name; ?></td>
                    <td style='text-align:center;'><?php echo $redeem_data->package_id()->name; ?></td>
                    <td style='text-align:center;'><?php echo $redeem_data->invoice_id; ?></td>
                    <td style='text-align:center;'><?php echo $redeem_data->qty; ?></td>
                    <td style='text-align:center;'><?php echo $redeem_data->balance; ?></td>
                  </tr>
                  <?php
                }
              }else{
                echo "<tr><td colspan='6' style='text-align:center;color:orange;font-size:20px;'>NOT REDEEMPTION RECORD AVAYLABLE</td></tr>";
              }
            }

              ?>

            </tbody>
          </table>

          <!-- table ends -->

        </div>

      </div>

    </div>
  </div>

</form>
<!-- content container ends -->
</body>
</html>
