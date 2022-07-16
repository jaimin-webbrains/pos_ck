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

 <?php Functions::output_result(); ?>
<div class="container-fluid">
  <div class="row">

    <div class="col-sm-12">
      <div class="col-sm-12" id='bottom-section'>

        <!-- form start -->
        <div class="col-sm-12" style="text-align:center;padding-bottom:30px;font-size:40px;">
          - CUSTOMER REGISTRATION -
        </div>
        <div class="col-sm-6">
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

          <div class="form-group">
            <label class="control-label col-sm-2" for="email">Refered By:</label>
            <div class="col-sm-10">
              <select name="refered_by" class="form-control customer_select">
                <option value="0" selected> NO REFERENCE </option>
                <?php
                // foreach( Customer::find_all() as $customer_data ){
                //   echo "<option value='".$customer_data->id."' >".$customer_data->full_name."</option>";
                // }
                 ?>
              </select>
            </div>
          </div>


          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <button type="submit" name="save" class="btn btn-primary btn-block" style="padding-bottom:30px;padding-top:30px;font-weight:700;"> - REGISTER - </button>
            </div>
          </div>
        </form>
      </div>

        <!-- form ends -->

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

</body>
</html>
