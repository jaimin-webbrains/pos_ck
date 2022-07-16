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

.customer_select22drop span {
  width:100% !important;
}

.customer_select22drop .select2-container--default .select2-selection--single .select2-selection__arrow b {
  left:98% !important;
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
      <div class="col-sm-6" id='bottom-section'>

        <?php Functions::output_result(); ?>

        <!-- invoice type selector -->

        <ul class="nav nav-tabs">
          <li class="active" style="width:200px;"><a data-toggle="tab" href="#home"> Exising Customer </a></li>
          <li class="" style="width:200px;"><a data-toggle="tab" href="#home2"> New Customer </a></li>
        </ul>

        <div class="tab-content">

          <div id="home" class="tab-pane fade in active">
            <h3>EXISITING CUSTOMER</h3>

            <!-- form start -->
            <form class="form-horizontal" action="proccess/invoice_process.php" method="post">
              <div class="form-group">
                <input type="hidden" name="invoice_init" value="1" />
                <label class="control-label col-sm-3" for="email"> Customer Name: </label>
                <div class="col-sm-9">
                <select class="form-control customer_select"  data-live-search="true" name="customer_id">
                  <option value="">Select</option>
                  <?php
                  // foreach(Customer::find_all() as $customer_data){
                  //   echo "<option value='".$customer_data->id."'>".$customer_data->full_name." - ".$customer_data->mobile." - ".$customer_data->email."</option>";
                  // }
                  ?>
                </select>
                </div>
              </div>


              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit"  class="btn btn-info btn-block" style="padding-top:25px;padding-bottom:25px;font-size:25px;" >- Proceed -</button>
                  <!-- <a href="invoice.php" class="btn btn-info btn-block" style="padding-top:25px;padding-bottom:25px;font-size:25px;" role="button"> - Proceed - </a> -->

                </div>
              </div>
            </form>
            <!-- form ends -->
          </div>

          <div id="home2" class="tab-pane fade in">
            <h3>NEW CUSTOMER</h3>
            <!-- form start -->
            <form class="form-horizontal" action="proccess/customer_process.php" method="post">

              <div class="form-group">
                <label class="control-label col-sm-2" for="email">Full Name:</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="full_name" placeholder="Full Name" autofocus>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-sm-2" for="email">Mobile Number:</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="mobile" placeholder="Mobile Number">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-sm-2" for="email">Email:</label>
                <div class="col-sm-10">
                  <input type="email" class="form-control" name="email" placeholder="Email">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-sm-2" for="email">Social Links:</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="social_link" placeholder="Social Links">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-sm-2" for="email">DOB:</label>
                <div class="col-sm-10">
                  <input type="date" class="form-control" name="dob" placeholder="DOB">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-sm-2" for="email">Customer Status:</label>
                <div class="col-sm-10">
                  <select name="customer_status" value="Active" selected class="form-control ">
                    <option value='Active' selected disabled>Active</option>  
                  </select>
                </div>
              </div>

              <div class="form-group customer_select22drop">
                <label class="control-label col-sm-2" for="email">Refered By:</label>
                <div class="col-sm-10">
                  <select class="form-control customer_select22"  data-live-search="true" name="refered_by">
                    <option value="">Select</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" name="saveIn" class="btn btn-primary btn-block" style="padding-bottom:30px;padding-top:30px;font-weight:700;"> - REGISTER - </button>
                </div>
              </div>
            </form>
            <!-- form ends -->
          </div>
        </div>

        <!-- end of invoice type selector -->
      </div>
    </div>

  </div>
</div>

</form>
<!-- content container ends -->
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

$('.customer_select22').select2({
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
</body>
</html>
