<?php
require_once './../util/initialize.php';
include 'common/upper_content.php';
$con=mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
if(isset($_POST['b1']))
{
	$p1=Functions::encrypt_string($_POST['pass']);
	$opt=$_POST['role_id'];
	if($opt==1)
	{
	$id=$_POST['email_id'];
	
	$get_q=mysqli_query($con,"update users set password='$p1' where email='$id'");
	}
	if($opt==2)
	{
		$id=$_POST['email_id'];
	
	$get_q=mysqli_query($con,"update customer set password='$p1' where email='$id'");
	}
	if($get_q)
	{
	?>
	
     <script>
			window.onload=function()
			{
				alert("Password Reset Succesfully");
				window.location="index.php";
			}
		</script>
    <?php
	}
	
}


?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Security Access Control</h3>
            </div>

            <div class="title_right"></div>
        </div>
        <div class="clearfix"></div>

        <?php
        Functions::output_result();
        ?>
 <form id="formRole"  method="post" class="form-horizontal form-label-left">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12" style="padding-left: 15%; padding-right: 15%;">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Please<small> Select User/Customer to continue</small></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="form-group">
                            <select class="form-control" id="cmbRole" name="role_id" required="">
                                <option disabled="" selected="">Select User/Customer</option>
								<option value="1">User</option>
								<option value="2">Customer</option>
                                <?php
								/*
                                foreach (Role::find_all() as $role) {
                                    ?>
                                    <option value="<?php echo $role->id; ?>"><?php echo $role->name; ?></option>
                                    <?php
                                }
								*/
                                ?>
                            </select>
							
                        </div>
                    </div>
                </div>
            </div>

          <div class="col-sm-12" id="reset_password_div"    style="padding-left: 15%; padding-right: 15%;">
                <div class="x_panel">
                    <div class="x_title">
                        <h2 id="title" style="font-weight:700;">Reset Password</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                       
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <input type="hidden" class="form-control" id="txtId" name="id" value="">
                                <div class="form-group">
								<label>Email </label>
										<input type="email" name="email_id" id="email_id" class="form-control" placeholder="Email id"  value="" required=""/>
										 <label style="color: red;" id="voucher_number_error1"></label>
										 <br>
                                    <label>Password </label>
                                   
                                    <input type="password" maxlength="60" class="form-control" placeholder="Password" id="p1" name="pass" value="" required="">
									<label>Confirm Password </label>
                                   
                                    <input type="password" maxlength="60" class="form-control" placeholder="Confirm Password" id="p2" name="cpass" value="" required="">
									<label id="passworderror"></label>
									
									<br>
									<br>
									 <input type="submit" style=" background-color: #2a3f54; color: white"  class="form-control" placeholder="Name" name="b1" value="Reset Password" >
                                </div>


                            </div>
                        
                    </div>
                </div>
              </div>
        </div>
    </div>
</div>
</form>
<!-- /page content -->

<?php include 'common/bottom_content.php'; ?><!-- bottom content -->

<script>
    


    
	$('#cmbRole').on("change", function(){
		var roleid = $(this).val();
		console.log(roleid);
		if (roleid) {
             $.ajax({
				url :"get_user_role_detail.php",
				type:"GET",
				cache:false,
				data:{roleid:roleid},
				success:function(data)
				{
					//console.log(data);
				voucher_list = JSON.parse(data);
	   console.log(voucher_list);
	   $("#email_id").on('input', function(){
		   console.log($(this).val());
		   if(voucher_list.indexOf($(this).val())>=0)
		   {
			   
			   $('#voucher_number_error1').text("Email is valid");
			   console.log("success");
		   }
		   else{
			   $('#voucher_number_error1').text("Email is Not Valid");
		   }
		   });
		}
		
		});
		}
		});
	$("#p2").on('input', function(){
		var password=$("#p1").val();
		var confirm_password=$(this).val();
		console.log(password+"/n"+confirm_password);
		if(password==confirm_password)
		{
			$("#passworderror").text("Password And Confirm Password is match");
			console.log("success");
		}else{
			$("#passworderror").text("Password And Confirm Password is not match");
			console.log("Error");
		}
			
	});

    
    
    

</script>

