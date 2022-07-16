<?php
require_once "../util/initialize.php";
include './common/upper_content.php';

//$user = User::find_by_id($_SESSION["user_id"]);

$user_id=$_SESSION["user"]["id"];
$user = User::find_by_id($user_id);


?>

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>User Profile</h3>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><?php echo $user->name ?><small> <?php echo $user->username ?></small></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
                            <div class="profile_img">
                                <div id="crop-avatar">
                                    <!-- Current avatar -->
                                    <?php
                                            $image = "images/user.png";
                                            if ($user->image) {
                                                $image = "uploads/users/" . $user->image;
                                            }
                                            ?>
                                    <img class="img-responsive avatar-view" src="<?php echo $image;?>" alt="Avatar" title="Change the avatar">
                                </div>
                            </div>
                            <h3><?php echo $user->name ?></h3>
                            <ul class="list-unstyled user_data">
                                <li><i class="fa fa-user-circle user-profile-icon"></i> <?php echo $user->username ?></li>
                                <li><i class="fa fa-id-card user-profile-icon"></i> <?php echo $user->nic ?></li>
                                <li><i class="fa fa-envelope user-profile-icon"></i> <?php echo $user->email ?></li>
                                <li><i class="fa fa-phone user-profile-icon"></i> <?php echo $user->contact_no ?></li>
                                <li><i class="fa fa-map-marker user-profile-icon"></i> <?php echo $user->address ?></li>
                                <li><i class="fa fa-briefcase user-profile-icon"></i> <?php echo $user->designation_id()->name ?></li>
                                <li><i class="fa fa-user-md user-profile-icon"></i> <?php echo $user->user_status_id()->name ?></li>
                                <li><i class="fa fa-group user-profile-icon"></i> Roles
                                    <ul class=" user_data">
                                        <?php
                                        $user_roles = UserRole::find_all_by_user_id($user->id);
                                        foreach ($user_roles as $user_role) {
                                            ?>
                                            <li><?php echo $user_role->role_id()->name ?></li>

                                            <?php
                                        }
                                        ?>
                                    </ul>
                                </li>
                            </ul>

                            <!--<button id="btnNew" type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="glyphicon glyphicon-edit"></i> Edit Profile</button>-->
                            <br />

                            <!--                            <div class="tile-stats">
                                                            <h2 class="col-sm-12"><b>Comission</b></h2>
                                                            <h3>Rs.8179546.00</h3>
                                                        </div>-->
                            <form id="userProfileEdit" action="user_profile_edit.php" method="post" target="_blank">
                                <input type="hidden" name="user_id" value="<?php echo $user->id; ?>"/>
                                <button type="submit" name="Edit Profile" class="btn btn-primary btn-sm" ><i class="fa fa-gears"></i> Change Username/Password</button>
                            </form>
                        </div>

                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Recent Activity</a>
                                    </li>
<!--                                    <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Tasks</a>
                                    </li>
                                    <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Messages</a>
                                    </li>-->
                                </ul>
                                <div id="myTabContent" class="tab-content">
                                    <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                                        <!-- start recent activity -->
                                        <table id="datatable-fixed-header" class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th >Activity</th>
                                                    <th >Log Date and Time</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach (Activity::find_all_by_user_id($user->id) as $activity) {
                                                    ?>
                                                    <tr>
                                                        <td><p><?php echo $activity->description ?></p></td>
                                                        <td> <?php echo $activity->date_time ?> </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                        <!-- end recent activity -->

                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="x_panel">
                                                <div class="x_title">
                                                    <h2>To Do List <small>Sample tasks</small></h2>
                                                    <ul class="nav navbar-right panel_toolbox">
                                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                                        </li>
                                                        <li class="dropdown">
                                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                                            <ul class="dropdown-menu" role="menu">
                                                                <li><a href="#">Settings 1</a>
                                                                </li>
                                                                <li><a href="#">Settings 2</a>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                                                        </li>
                                                    </ul>
                                                    <div class="clearfix"></div>
                                                </div>
                                                <div class="x_content">

                                                    <div class="">
                                                        <ul class="to_do">
                                                            <li>
                                                                <p>
                                                                    <input type="checkbox" class="flat"> Schedule meeting with new client </p>
                                                            </li>
                                                            <li>
                                                                <p>
                                                                    <input type="checkbox" class="flat"> Create email address for new intern</p>
                                                            </li>
                                                            <li>
                                                                <p>
                                                                    <input type="checkbox" class="flat"> Have IT fix the network printer</p>
                                                            </li>
                                                            <li>
                                                                <p>
                                                                    <input type="checkbox" class="flat"> Copy backups to offsite location</p>
                                                            </li>
                                                            <li>
                                                                <p>
                                                                    <input type="checkbox" class="flat"> Food truck fixie locavors mcsweeney</p>
                                                            </li>
                                                            <li>
                                                                <p>
                                                                    <input type="checkbox" class="flat"> Food truck fixie locavors mcsweeney</p>
                                                            </li>
                                                            <li>
                                                                <p>
                                                                    <input type="checkbox" class="flat"> Create email address for new intern</p>
                                                            </li>
                                                            <li>
                                                                <p>
                                                                    <input type="checkbox" class="flat"> Have IT fix the network printer</p>
                                                            </li>
                                                            <li>
                                                                <p>
                                                                    <input type="checkbox" class="flat"> Copy backups to offsite location</p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
                                        <p>xxFood truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui
                                            photo booth letterpress, commodo enim craft beer mlkshk </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->
<?php include './common/bottom_content.php'; ?><!-- bottom content -->
<script>
    if ($('#graph_bar1').length) {
        Morris.Bar({
            element: 'graph_bar1',
            data: [
                {device: 'iPhone 4', geekbench: 380},
                {device: 'iPhone 4S', geekbench: 655},
                {device: 'iPhone 3GS', geekbench: 275},
                {device: 'iPhone 5', geekbench: 1571},
                {device: 'iPhone 5S', geekbench: 655},
                {device: 'iPhone 6', geekbench: 2154},
                {device: 'iPhone 6 Plus', geekbench: 1144},
                {device: 'iPhone 6S', geekbench: 2371},
                {device: 'iPhone 6S Plus', geekbench: 1471},
                {device: 'Other', geekbench: 1371}
            ],
            xkey: 'device',
            ykeys: ['geekbench'],
            labels: ['Geekbench'],
            barRatio: 0.4,
            barColors: ['#26B99A', '#34495E', '#ACADAC', '#3498DB'],
            xLabelAngle: 35,
            hideHover: 'auto',
            resize: true
        });

        if ($('#graph_line1').length) {

            Morris.Line({
                element: 'graph_line1',
                xkey: 'year',
                ykeys: ['value'],
                labels: ['Value'],
                hideHover: 'auto',
                lineColors: ['#26B99A', '#34495E', '#ACADAC', '#3498DB'],
                data: [
                    {year: '2012', value: 20},
                    {year: '2013', value: 10},
                    {year: '2014', value: 5},
                    {year: '2015', value: 5},
                    {year: '2016', value: 20}
                ],
                resize: true
            });

            $MENU_TOGGLE.on('click', function () {
                $(window).resize();
            });

        }
    }
</script>