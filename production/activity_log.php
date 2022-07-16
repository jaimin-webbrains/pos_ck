<?php
require_once './../util/initialize.php';
include './common/upper_content.php';
?><!-- upper content -->
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Activity Log</h3>
            </div>

            <div class="title_right">
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Activity History<small>Leeshya Distributors</small></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="tblMain" class="table table-striped">
                            <thead>
                                <tr>
                                    <th >User</th>
                                    <th >Designation</th>
                                    <th >Activity</th>
                                    <th >Date & Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total_records = Activity::row_count();
                                $pagination = new Pagination($total_records);
                                $objects = Activity::find_all_by_limit_offset_custom($pagination->records_per_page, $pagination->offset());

                                foreach ($objects as $activity) {
                                    ?>
                                    <tr>
                                        <td>
                                            <?php
                                            $image = "images/user.png";
                                            if ($user->image) {
                                                $image = "uploads/users/" . $user->image;
                                            }
                                            ?>
                                            <div class="col-md-2">
                                                <img src="<?php echo $image; ?>" class="avatar" alt="user">
                                            </div>
                                            <div class="col-md-10">
                                                <?php echo $activity->user_id()->name ?>
                                            </div>
                                        </td>
                                        <td><?php echo $activity->user_id()->designation_id()->name ?></td>
                                        <td><p><?php echo $activity->description ?></p></td>
                                        <td> <?php echo $activity->date_time ?> </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
<!--                </div>
                <div class="x_panel">-->
                    <div onclick="window.location.href:''" class="x_content">
                        <?php
                        echo $pagination->get_pagination_links_html1("activity_log.php");
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->
<?php include './common/bottom_content.php'; ?>

<script>
    window.onfocus = function () {
//        location.reload(); 
    };

    $(document).ready(function () {
        $('#tblMain').DataTable({
            "paging": false,
//            "ordering": false,
            "info": false
        });
    });

</script>