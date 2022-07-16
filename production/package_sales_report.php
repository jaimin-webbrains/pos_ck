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
            <h2 id="title" style="font-weight:700;"> - PACKAGE SALES REPORT - (Branch & Date)</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <!-- form start -->
            <form class="form-inline" method="post" action="package_sales_print.php" target="_blank">
              <?php                  
              $nm = $_SESSION["user"]["name"];
              ?>             
              <?php
              $checked = 0;			  
              foreach (UserRole::find_all_by_user_id($_SESSION["user"]["id"]) as $user_role_data ) {
                // echo "<h1>$user_role_data->role_id</h1>";
                if($user_role_data->role_id == 1) {					
                  $checked = 1;
                }
              }
              ?>
			        <div class="form-group" style="margin-right:30px;">
                <div>
                  <label for="contact_email">All Branches</label>  
                </div>
                <div>
                  <input type="radio" name="allbranches" id="allbranches_all_1" value="all" checked/>
                  <label for="allbranches_all_1">Yes</label>
                  <input type="radio" name="allbranches" id="allbranches_one_1" value="one" style="margin-left:30px;"/>
                  <label for="allbranches_one_1">No</label>
                </div>
              </div>
              <div class="form-group">
                <label>Branch:</label><br/>
                <select class="form-control" name="branch" id="branch_1">
                   <?php				  
                    if($checked == 1) {                   			  
                      foreach (Branch::find_all() as $data) {
                        echo "<option value='".$data->id."'>".$data->name."</option>";
                      }
                    }
                    elseif($user_role_data->role_id == 2) {
                      foreach (Branch::find_all() as $data) {
                        echo "<option value='".$data->id."'>".$data->name."</option>";
                      }
                    }
                    elseif($user_role_data->role_id == 4) {
                      $q11="SELECT users.branch_id,branch.name FROM `users` JOIN branch ON users.branch_id=branch.id WHERE users.id = '".$_SESSION["user"]["id"]."'" ;
                        $retv22=mysqli_query($con,$q11);
                        $res1=mysqli_fetch_array($retv22);
                        
                        echo "<option value='".$res1['branch_id']."'>".$res1['name']."</option>";
                    }
                    elseif($user_role_data->role_id == 3 or $user_role_data->role_id == 7) {
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
          <div class="x_title">
            <h2 id="title" style="font-weight:700;"> - PACKAGE SALES REPORT - (Branch & Month)</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <!-- form start -->
            <form class="form-inline" method="post" action="package_sales_print.php" target="_blank">
              <?php
              $checked = 0;			  
              foreach (UserRole::find_all_by_user_id($_SESSION["user"]["id"]) as $user_role_data ) {
                // echo "<h1>$user_role_data->role_id</h1>";
                if($user_role_data->role_id == 1) {					
                  $checked = 1;
                }
              }
              ?>
              <div class="form-group" style="margin-right:30px;">
                <div>
                  <label for="contact_email">All Branches</label>  
                </div>
                <div>
                  <input type="radio" name="allbranches" id="allbranches_all_2" value="all" checked/>
                  <label for="allbranches_all_2">Yes</label>
                  <input type="radio" name="allbranches" id="allbranches_one_2" value="one" style="margin-left:30px;"/>
                  <label for="allbranches_one_2">No</label>
                </div>
              </div>
			        <div class="form-group">
                <label>Branch:</label><br/>
                <select class="form-control" name="branch" id="branch_2">
                   <?php				  
                    if($checked == 1) {                   			  
                      foreach (Branch::find_all() as $data) {
                        echo "<option value='".$data->id."'>".$data->name."</option>";
                      }
                    }
                    elseif($user_role_data->role_id == 2) {
                      foreach (Branch::find_all() as $data) {
                        echo "<option value='".$data->id."'>".$data->name."</option>";
                      }
                    }
                    elseif($user_role_data->role_id == 4) {
                      $q11="SELECT users.branch_id,branch.name FROM `users` JOIN branch ON users.branch_id=branch.id WHERE users.id = '".$_SESSION["user"]["id"]."'" ;
                        $retv22=mysqli_query($con,$q11);
                        $res1=mysqli_fetch_array($retv22);
                        
                        echo "<option value='".$res1['branch_id']."'>".$res1['name']."</option>";
                    }
                    elseif($user_role_data->role_id == 3 or $user_role_data->role_id == 7) {
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
                <label>YEAR:</label><br/>
                <select class="form-control" name="year">
                  <option value='2020' >2020</option>
                  <option value='2021' >2021</option>
                  <option value='2022' >2022</option>
                  <option value='2023' >2023</option>
                </select>
              </div>

              <div class="form-group">
                <label>MONTH:</label><br/>
                <select class="form-control" name="month">
                  <option value="1">JANUARY</option>
                  <option value="2">FEBRUARY</option>
                  <option value="3">MARCH</option>
                  <option value="4">APRIL</option>
                  <option value="5">MAY</option>
                  <option value="6">JUNE</option>
                  <option value="7">JULY</option>
                  <option value="8">AUGUST</option>
                  <option value="9">SEPTMBER</option>
                  <option value="10">OCTOMBER</option>
                  <option value="11">NOVEMBER</option>
                  <option value="12">DECEMBER</option>
                </select>
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
      <!-- THIRD COLUMN -->
      <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
          <div class="x_title">
            <h2 id="title" style="font-weight:700;"> - PACKAGE SALES REPORT - (Branch & Year)</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <!-- form start -->
            <form class="form-inline" method="post" action="package_sales_print.php" target="_blank">
            <?php
              $checked = 0;			  
              foreach (UserRole::find_all_by_user_id($_SESSION["user"]["id"]) as $user_role_data ) {
                // echo "<h1>$user_role_data->role_id</h1>";
                if($user_role_data->role_id == 1) {					
                  $checked = 1;
                }
              }
              ?>
              <div class="form-group" style="margin-right:30px;">
                <div>
                  <label for="contact_email">All Branches</label>  
                </div>
                <div>
                  <input type="radio" name="allbranches" id="allbranches_all_3" value="all" checked/>
                  <label for="allbranches_all_3">Yes</label>
                  <input type="radio" name="allbranches" id="allbranches_one_3" value="one" style="margin-left:30px;"/>
                  <label for="allbranches_one_3">No</label>
                </div>
              </div>
			        <div class="form-group">
                <label>Branch:</label><br/>
                <select class="form-control" name="branch" id="branch_3">
                   <?php				  
                    if($checked == 1) {                   			  
                      foreach (Branch::find_all() as $data) {
                        echo "<option value='".$data->id."'>".$data->name."</option>";
                      }
                    }
                    elseif($user_role_data->role_id == 2) {
                      foreach (Branch::find_all() as $data) {
                        echo "<option value='".$data->id."'>".$data->name."</option>";
                      }
                    }
                    elseif($user_role_data->role_id == 4) {
                      $q11="SELECT users.branch_id,branch.name FROM `users` JOIN branch ON users.branch_id=branch.id WHERE users.id = '".$_SESSION["user"]["id"]."'" ;
                        $retv22=mysqli_query($con,$q11);
                        $res1=mysqli_fetch_array($retv22);
                        
                        echo "<option value='".$res1['branch_id']."'>".$res1['name']."</option>";
                    }
                    elseif($user_role_data->role_id == 3 or $user_role_data->role_id == 7) {
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
                <label>YEAR:</label><br/>
                <select class="form-control" name="year">
                  <option value='2020' >2020</option>
                  <option value='2021' >2021</option>
                  <option value='2022' >2022</option>
                  <option value='2023' >2023</option>
                </select>
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
    </div>
  </div>
</div>
<!--/page content-->
<?php include 'common/bottom_content.php'; ?> bottom content
<script>
$(document).ready(() => {
  $('#branch_1').attr("disabled", "true");
  $('#branch_2').attr("disabled", "true");
  $('#branch_3').attr("disabled", "true");


  $("#allbranches_all_1").click(() => {
    $('#branch_1').attr("disabled", "true");
  });
  $("#allbranches_one_1").click(() => {
    $('#branch_1').removeAttr("disabled");
  });

  $("#allbranches_all_2").click(() => {
    $('#branch_2').attr("disabled", "true");
  });
  $("#allbranches_one_2").click(() => {
    $('#branch_2').removeAttr("disabled");
  });

  $("#allbranches_all_3").click(() => {
    $('#branch_3').attr("disabled", "true");
  });
  $("#allbranches_one_3").click(() => {
    $('#branch_3').removeAttr("disabled");
  });
});
 
  // state dependent ajax
  // $("#branch").on("change", function(){
  //     var branchid = $(this).val();
  //     console.log(branchid);
  //     if (branchid) {
  //         $.ajax({
  //         url :"get_service_user.php",
  //         type:"POST",
  //         cache:false,
  //         data:{branchid:branchid},
  //         success:function(data){
  //         //console.log(data);
  //           $("#service_user").html(data);
  //         }
  //       });
  //     } else {
  //       $('#service_user').html('<option value="">Select Subcategory</option>');
  //     } 
  // });

  

  
</script>
