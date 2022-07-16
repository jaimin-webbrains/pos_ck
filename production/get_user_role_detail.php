<?php
require_once './../util/initialize.php';
$con=mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
$row=array();
if(isset($_GET['roleid']))
{
	$id=$_GET['roleid'];
	if($id==1)
	{
	$user_res=mysqli_query($con,"select email from users");
	$num_rows=mysqli_num_rows($user_res);
	if($num_rows>0)
	{
		
		
		//echo "<option >Select User<option>";
		while($user_rec=mysqli_fetch_array($user_res))
		{
			$row[]=$user_rec['email'];
			
			//echo '<option value="'.$user_rec['user_id'].'">'.$user_rec['email'].'</option>';
		}
		echo json_encode($row);
	}
	}
	else{
	//$user_res=mysqli_query($con,"select user_role.*,users.email from user_role JOIN users ON user_role.user_id=users.id where role_id='$id'");
	$user_res=mysqli_query($con,"select email from customer");
	$num_rows=mysqli_num_rows($user_res);
	if($num_rows>0)
	{
		while($user_rec=mysqli_fetch_array($user_res))
		{
			$row[]=$user_rec['email'];
			
			//echo '<option value="'.$user_rec['user_id'].'">'.$user_rec['email'].'</option>';
		}
		echo json_encode($row);
		
	}
	}
}

?>