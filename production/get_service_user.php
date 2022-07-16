<?php
include "../util/initialize.php";
$con=mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
	if(isset($_POST['branchid']))
	{
		$branchid=$_POST['branchid'];
		// $fetch_service_user="select * from users JOIN user_role ON users.id=user_role.user_id where FIND_IN_SET('$branchid',branch_id) and role_id='2'";
		$fetch_service_user="select * from users WHERE branch_id = '$branchid' AND designation_id = '5'";
		$query=mysqli_query($con,$fetch_service_user);
		$num_rows=mysqli_num_rows($query);
		if($num_rows>0)
		{
			echo "<option value='1'>All</option>";
			while($user_rec=mysqli_fetch_array($query))
			{
				echo '<option value="'.$user_rec[0].'">'.$user_rec['name'].'</option>';
			}
		}else{
			echo "<option>Select User</option>";
		}

	}
?>
