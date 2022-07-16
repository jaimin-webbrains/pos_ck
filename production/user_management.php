<?php
require_once './../util/initialize.php';
include 'common/upper_content.php';
$con=mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
?>

<!--page content-->

<div class="right_col" role="main" style="width:fit-content;>
    <div class="">
        <div class="page-title">
            <div class="title_left">
			<br/>
                <h3>User Management</h3>
            </div>

            <div class="title_right">

            </div>
        </div>

        <div class="clearfix"></div>
        <?php Functions::output_result(); ?>
        <div class="row" style="width:fit-content;">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <a href="user.php" target="_blank"><button id="btnNew" type="button" class="btn btn-round btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="glyphicon glyphicon-plus"></i> Add New</button></a>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Full Name</th>
                                    <th>Username</th>
                                    <th>NIC</th>
                                    <th>Contact No</th>
                                    <th>e-Mail</th>
                                    <th>Address</th>
                                    <th>Branch</th>
                                    <th>Status</th>
                                    <th class="col-sm-2">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php

                                // $total_records = User::row_count();
                                // $pagination = new Pagination($total_records);
                                // $objects = User::find_all_by_limit_offset($pagination->records_per_page, $pagination->offset());

                                $objects = User::find_all();
                                foreach ($objects as $user) {
                                    ?>
                                    <tr>
                                        <td><?php echo $user->id ?></td>
                                        <td><?php echo $user->name ?></td>
                                        <td><?php echo $user->username ?></td>
                                        <td><?php echo $user->nic ?></td>
                                        <td><?php echo $user->contact_no ?></td>
                                        <td><?php echo $user->email ?></td>
                                        <td><?php echo $user->address ?></td>
                                        <td><?php
                                        if($user->branch_id=='all')
											{
												echo "All";
											}
                                        else if($user->branch_id!=NULL or $user->branch_id!='' )
                                        {
										 $ar1 = explode(",",$user->branch_id);
											foreach($ar1 as $d1)
											{
												$q111="SELECT name,id FROM `branch`  WHERE id = '$d1'" ;
					  $retv222=mysqli_query($con,$q111);
					  $res12=mysqli_fetch_array($retv222);
										echo $res12['name'].",";
											}
										}
										?>
										</td>
                                        <td><?php echo $user->user_status_id()->name ?></td>
                                        <td>
                                            <form action="user.php" method="post" target="_blank" style="float: left;">
                                                <input type="hidden" name="id" value="<?php echo $user->id ?>"/>
                                                <button type="submit" name="view" class="btn btn-primary btn-xs" ><i class="glyphicon glyphicon-edit"></i> Edit</button>
                                            </form>
                                            <form action="user_profile.php" method="post" target="_blank" >
                                                <input type="hidden" name="user_id" value="<?php echo $user->id ?>"/>
                                                <button type="submit" name="view" class="btn btn-primary btn-xs" ><i class="glyphicon glyphicon-new-window"></i> View</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="x_panel">
                    <div onclick="window.location.href:''" class="x_content">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--/page content-->
<?php include 'common/bottom_content.php'; ?>

<script>
    window.onfocus = function () {
        location.reload();
    };
</script>
