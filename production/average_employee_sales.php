<?php
require_once './../util/initialize.php';
include 'common/upper_content.php';
$con=mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
?>

<!--page content-->
<div class="right_col" role="main">
  <div class="">

    <?php Functions::output_result(); ?>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2 id="title" style="font-weight:700;"> - AVERAGE EMPLOYEE SALES REPORT - </h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <!-- form start -->

            <form class="form-inline" method="post" action="average_employee_sales_print.php" target="_blank">
              <?php

              $nm=$_SESSION["user"]["name"];?>

              <?php
              $checked = 0;

              foreach (UserRole::find_all_by_user_id($_SESSION["user"]["id"]) as $user_role_data ) {
             //   echo "<h1>$user_role_data->role_id</h1>";
             // role id = 1 admin   
             if($user_role_data->role_id == 1){
                  $checked = 1;
                }
              }
              ?>

              <div class="form-group">
                <label>Branch:</label><br/>
                <select class="form-control" name="branch" id="branch">
                  <?php

                  if($checked == 1){

                    foreach (Branch::find_all() as $data) {
                      echo "<option value='".$data->id."'>".$data->name."</option>";
                    }
                  }
                  elseif($user_role_data->role_id == 2){
                    foreach (Branch::find_all() as $data) {
                      echo "<option value='".$data->id."'>".$data->name."</option>";
                    }
                  }
                  elseif($user_role_data->role_id == 4){
                    $q11="SELECT users.branch_id,branch.name FROM `users` JOIN branch ON users.branch_id=branch.id WHERE users.id = '".$_SESSION["user"]["id"]."'" ;
                    $retv22=mysqli_query($con,$q11);
                    $res1=mysqli_fetch_array($retv22);

                    echo "<option value='".$res1['branch_id']."'>".$res1['name']."</option>";


                  }
                  elseif($user_role_data->role_id == 3 or $user_role_data->role_id == 7){
                    $q11="SELECT users.branch_id FROM `users`  WHERE users.id = '".$_SESSION["user"]["id"]."'" ;
                    $retv22=mysqli_query($con,$q11);
                    $res1=mysqli_fetch_array($retv22);
                    if($res1[0]=='all')
                    {
                      foreach (Branch::find_all() as $data) {
                        echo "<option value='".$data->id."'>".$data->name."</option>";
                      }

                    }
                    else
                    {
                      $ar1 = explode(",",$res1[0]);
                      foreach($ar1 as $d1)
                      {
                        $q111="SELECT name,id FROM `branch`  WHERE id = '$d1'" ;
                        $retv222=mysqli_query($con,$q111);
                        $res12=mysqli_fetch_array($retv222);

                        echo "<option value='".$res12['id']."'>".$res12['name']."</option>";
                      }
                    }
                  }
                  else
                  {
                    foreach (Branch::find_all() as $data) {
                      echo "<option value='".$data->id."'>".$data->name."</option>";
                    }

                  }

                  ?>
                </select>
              </div>


              <div class="form-group">
                <label>Service User:</label><br/>
                <select class="form-control" name="service_user" id="service_user">

                  <option value="1" >All</option>
                  
                  <?php

                  if($checked == 1){
                    ?>
                   <option value="1" selected> ALL </option>
                         <?php
                    foreach (User::find_all_service_branchs() as $data) {
                      echo "<option value='".$data->id."'>".$data->name."</option>";
                    }
                  }else if($user_role_data->role_id == 2)
                  {
                    ?>
                    <option value="<?php echo $_SESSION["user"]["id"]; ?>" selected><?php echo  $nm;?> </option>
                    <?php
                  }
                  else{

                    foreach (User::find_all_service_branchs() as $data) {
                      echo "<option value='".$data->id."'>".$data->name."</option>";
                    }
                  }

                  ?>
                </select>
              </div>

              <div class="form-group">
                <label for="pwd">From Date:</label><br/>
                <input type="date" class="form-control" name="from_date" required>
              </div>

              <div class="form-group">
                <label for="pwd">To Date:</label><br/>
                <input type="date" class="form-control" name="to_date" required>
              </div>

              <div class="form-group">
                <br/>
                <button type="submit" class="btn btn-primary">FIND</button>
              </div>                     
            </form>

            <!-- form ends -->
          </div>
        </div>
      </div>
    
      <!-- SECOND COLUMN -->

      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_content">

          </div>
        </div>
      </div>



    </div>
  </div>
</div>
<!--/page content-->
<?php include 'common/bottom_content.php'; ?> bottom content
<script>

// state dependent ajax
$("#branch").on("change", function(){
  var branchid = $(this).val();
  console.log(branchid);
  if (branchid) {
    $.ajax({
      url :"get_service_user.php",
      type:"POST",
      cache:false,
      data:{branchid:branchid},
      success:function(data){
        //console.log(data);
        $("#service_user").html(data);
      }
    });
  }else{
    $('#service_user').html('<option value="">Select Subcategory</option>');
  }
});
</script>
