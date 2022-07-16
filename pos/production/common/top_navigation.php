<?php
$user = User::find_by_id($_SESSION["user"]["id"]);
?>

<div class="top_nav">
    <div class="nav_menu">
        <nav>
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>
            
            <ul class="nav navbar-nav navbar-right">
                <li class="">
                    <a style="cursor: pointer;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <?php
                        $image = "images/user.png";
                        if ($user->image) {
                            $image = "uploads/users/" . $user->image;
                        }
                        ?>
                        <img src="<?php echo $image; ?>" alt=""><?php echo $user->username; ?>
                        <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li><a href="./user_profile.php"> Profile</a></li>
                        <li><a href="./user_profile_edit.php"> Edit Profile</a></li>
                        <li><a href="">Help</a></li>
                        <li><a href="./logout.php"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                    </ul>
                </li>

                <li role="presentation" class="dropdown">
                    <a style="cursor: pointer;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-5x fa-globe"></i>
                        <span class="badge bg-green "><i class="fa fa-asterisk" style="font-size:8px;"></i></span>
                    </a>
                    <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                        <?php
                        if ($activitys = Activity::find_all_limit_10()) {
                            foreach ($activitys as $activity) {
                                ?>
                                <li>
                                    <a>
                                        <!--<span class="image"><img src="<?php // echo $image; ?>" alt="Profile Image" /></span>-->

                                        <span>
                                            <span><?php echo $activity->user_id()->username; ?></span>
                                            <span class="time"><?php echo $activity->date_time; ?></span>
                                        </span>
                                        <span class="message">
                                            <?php echo $activity->description; ?>
                                        </span>

                                    </a>
                                </li>
                                <?php
                            }
                            ?>
                            <li>
                                <div class="text-center">
                                    <a href="activity_log.php" target="blank">
                                        <strong>See All Activities</strong>
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                </div>
                            </li>
                            <?php
                        } else {
                            ?>
                            <li>No activity available in dtatbase</li>
                            <?php
                        }
                        ?>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>


