<?php
require_once __DIR__ . '/../../util/initialize.php';

$user = User::find_by_id($_SESSION["user"]["id"]);
?>
<div class="col-md-3 left_col ">
  <div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0;">
      <a href="index.php" class="site_title"><i class="fa fa-home "></i> <span><?php echo ProjectConfig::$project_name; ?></span></a>
    </div>
    <div class="clearfix"></div>

    <!-- menu profile quick info -->
    <div class="profile clearfix">
      <div class="profile_pic" >
        <?php
        $image = "images/user.png";
        if ($user->image) {
          $image = "uploads/users/" . $user->image;
        }
        ?>
        <img src="<?php echo $image; ?>" alt="..." class="img-circle profile_img">
        <!--<figure style="height: 3em; width: 3em;">
        <img style="border-radius: 100%" class="img-responsive image_fit " src="<?php // echo 'uploads/users/'.$user->image;               ?>"  alt="Image not found" onerror="this.src='images/user.png';">
      </figure>-->
    </div>

    <div class="profile_info">
      <span>Welcome,</span>
      <h2><?php echo $user->name; ?></h2>
    </div>
    <div class="clearfix"></div>
  </div>
  <!-- /menu profile quick info -->
  <br />
  <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
      <!--<h3>General</h3>-->
        <ul class="nav side-menu">
          <li><a><i class="fa fa-sticky-note" aria-hidden="true"></i>Registrations <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <div class="menu_heading"><label >EDIT</label></div>
              <?php
              if(Functions::check_privilege_by_module_action("E-Payment","view")){
                echo '<li><a href="epayments.php"> E-Payment Operator </a></li>';
              }
              if(Functions::check_privilege_by_module_action("Brand","view")){
                echo '<li><a href="product_category.php"> Product brand </a></li>';
              }
              if(Functions::check_privilege_by_module_action("Service_Category","view")){
                echo '<li><a href="service_category.php"> Category </a></li>';
              }
              if(Functions::check_privilege_by_module_action("Packge_Category","view")){
                // echo '<li><a href="package_category.php"> Packge Category </a></li>';
              }
              if(Functions::check_privilege_by_module_action("Product","view")){
                echo '<li><a href="product.php"> Product Sales</a></li>';
              }
              if(Functions::check_privilege_by_module_action("ProductUnit","view")){
                echo '
                <li><a> Product Use <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                <!--<div class="menu_heading"><label >Product Use</label></div>-->
                <li><a href="product_unit.php"> + Product Use Stock</a></li>
                <li><a href="product_usage.php"> + Product Sales </a></li>
                <li><a href="product_services.php"> + Product Service </a></li>
                </ul>
                </li>

                ';
              }
              if(Functions::check_privilege_by_module_action("Colour","view")){
                echo '<li><a href="colour.php"> Colour Sales </a></li>';
              }
              if(Functions::check_privilege_by_module_action("ColourTube","view")){
                echo '<li><a href="colour_tube.php"> Colour Tube </a></li>';
              }
              if(Functions::check_privilege_by_module_action("Service","view")){
                echo '<li><a href="service.php"> Service </a></li>';
              }
              if(Functions::check_privilege_by_module_action("Package","view")){
                echo '<li><a href="package.php"> Package </a></li>';
              }

              ?>


            </ul>
          </li>

          <li><a><i class="fa fa-users" aria-hidden="true"></i>Customer Registrations <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <div class="menu_heading"><label >EDIT</label></div>
              <?php

              if(Functions::check_privilege_by_module_action("Customer_Status","view")){
                echo '<li><a href="customer_status.php">Customer Status</a></li>';
              }
              if(Functions::check_privilege_by_module_action("Customer","view")){
                echo '<li><a href="customer.php"> Customer</a></li>';
              }


              ?>
            </ul>
          </li>

          <li><a><i class="fa fa-window-restore" aria-hidden="true"></i>Branch <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <div class="menu_heading"><label >EDIT</label></div>
              <?php
              if(Functions::check_privilege_by_module_action("Branch","view")){
                echo '<li><a href="branch.php"> Branch </a></li>';
                echo '<li><a href="branch_working_time.php"> Branch Working Time </a></li>';
              }

              ?>

            </ul>
          </li>


          <li><a><i class="fa fa-window-restore" aria-hidden="true"></i>Feedback <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <div class="menu_heading"><label >VIEW</label></div>
              <?php
              if(Functions::check_privilege_by_module_action("Feedback","view")){
                echo '<li><a href="feedback.php"> Feedback </a></li>';
              }
              ?>

            </ul>
          </li>

          <li><a><i class="fa fa-window-restore" aria-hidden="true"></i>Security Access Control<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <div class="menu_heading"><label >VIEW</label></div>
              <?php
              if(Functions::check_privilege_by_module_action("security access control","view")){
                echo '<li><a href="reset_password.php"> Reset Password</a></li>';
              }
              ?>

            </ul>
          </li>

          <li><a><i class="fa fa-id-card" aria-hidden="true"></i>Advertisment <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <div class="menu_heading"><label >EDIT</label></div>
              <?php
              if(Functions::check_privilege_by_module_action("Advertisment","view")){
                echo '<li><a href="advertisment.php"> Advertisment </a></li>';
              }

              ?>

            </ul>
          </li>

          <li><a><i class="fa fa-id-card-o" aria-hidden="true"></i>Voucher <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <div class="menu_heading"><label >VIEW</label></div>
              <?php
              if(Functions::check_privilege_by_module_action("Voucher For Sales Wise","view")){
                echo '<li><a href="sales_wise_voucher.php"> Voucher For Higher Sales  </a></li>';
              }
              if(Functions::check_privilege_by_module_action("Voucher for Birthday Month","view")){
                echo '<li><a href="birthday_voucher.php"> Voucher For Birthday Month </a></li>';
              }
              if(Functions::check_privilege_by_module_action("Voucher for Joined Month","view")){
                echo '<li><a href="joined_voucher.php"> Voucher For Joined Month </a></li>';
              }
              if(Functions::check_privilege_by_module_action("Voucher For Selected Customer","view")){
                echo '<li><a href="custom_voucher.php"> Voucher For Selected Customer </a></li>';
              }
              // if(Functions::check_privilege_by_module_action("Voucher for Staff","view")){
                echo '<li><a href="for_staff_voucher.php"> Voucher For Staff </a></li>';
              // }
              ?>

              <div class="menu_heading"><label >MANAGEMENT</label></div>
              <?php
              if(Functions::check_privilege_by_module_action("Voucher Management","view")){
                echo '<li><a href="sales_wise_voucher_management.php"> Voucher Management  </a></li>';
              }
              ?>

            </ul>
          </li>

          <li><a><i class="fa fa-newspaper-o" aria-hidden="true"></i>RSS Feed <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <div class="menu_heading"><label >EDIT</label></div>
              <?php
              if(Functions::check_privilege_by_module_action("RSS","view")){
                echo '<li><a href="news_feed.php"> RSS Feed </a></li>';
              }
              ?>

            </ul>
          </li>

          <li><a><i class="fa fa-cogs" aria-hidden="true"></i>Settings <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <div class="menu_heading"><label >EDIT</label></div>
              <?php
              if(Functions::check_privilege_by_module_action("Branch","ins")){
                echo '<li><a href="settings.php"> Branch </a></li>';
              }
              ?>
            </ul>
          </li>

          <li><a><i class="fa fa-user" aria-hidden="true"></i>User Administration <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <div class="menu_heading"><label >EDIT</label></div>
              <?php
              if(Functions::check_privilege_by_module_action("User","ins")){
                echo '<li><a href="user.php"> User</a></li>';
              }
              if(Functions::check_privilege_by_module_action("Role","ins")){
                echo '<li><a href="role.php"> Role</a></li>';
              }
              if(Functions::check_privilege_by_module_action("Designation","ins")){
                echo '<li><a href="designation.php"> Designation</a></li>';
              }
              if(Functions::check_privilege_by_module_action("Privilege","ins")){
                echo '<li><a href="privilege_management.php">Privilege Management</a></li>';
              }

              ?>

              <div class="menu_heading"><label>REPORTS</label></div>
              <?php

              if(Functions::check_privilege_by_module_action("User","view")){
                echo '<li><a href="user_management.php">User Management</a></li>';
              }
              if(Functions::check_privilege_by_module_action("Role","view")){
                echo '<li><a href="role_management.php">Role Management</a></li>';
              }
              if(Functions::check_privilege_by_module_action("Designation","view")){
                echo '<li><a href="designation_management.php">Designation Management</a></li>';
              }

              ?>
            </ul>
          </li>


          <li><a><i class="fa fa-line-chart" aria-hidden="true"></i>My Perfomance <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <div class="menu_heading"><label >VIEW</label></div>

              <?php
              if(Functions::check_privilege_by_module_action("My Perfomance","view")){
                echo '<li><a href="perfomance.php">My Performance</a></li>';
              }
              ?>

            </ul>
          </li>

          <li><a><i class="fa fa-list" aria-hidden="true"></i>Reports<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">

              <?php

              if(Functions::check_privilege_by_module_action("Reward Point Detailed","view")){
                echo '<li><a href="reward_point.php">Reward Point Detailed</a></li>';
              }
              if(Functions::check_privilege_by_module_action("Branch & Employee Report","view")){
                echo '<li><a href="branch_employee.php">Branch & Employee Report</a></li>';
              }
              // if(Functions::check_privilege_by_module_action("Average Employee Sales Report","view")){
                echo '<li><a href="average_employee_sales.php">Average Employee Sales Report</a></li>';
              // }
              if(Functions::check_privilege_by_module_action("POS Transaction Report","view")){
                echo '<li><a href="pos_transaction.php">POS Transaction Report</a></li>';
              }
              if(Functions::check_privilege_by_module_action("Queue System Report","view")){
                echo '<li><a href="queue_system.php">Queue System Report</a></li>';
              }
              if(Functions::check_privilege_by_module_action("Customer Wise Report","view")){
                echo '<li><a href="customer_wise_report.php">Customer Wise Report</a></li>';
              }
              if(Functions::check_privilege_by_module_action("Sales Type Report","view")){
                echo '<li><a href="sales_type_report.php">Sales Type Report</a></li>';
              }
              if(Functions::check_privilege_by_module_action("Daily Overall Sales Report","view")){
                echo '<li><a href="daily_overall_sales.php">Daily Overall Sales Report</a></li>';
              }
              ?>
              <li>
                <a href="invoice_deleted.php">Invoice Deleted Report</a>
              </li>
              <li>
                <a href="invoice_payment.php">Invoice Payment Report</a>
              </li>
            </ul>
          </li>

          <li><a><i class="fa fa-users" aria-hidden="true"></i>Inventory Report <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <?php

              if(Functions::check_privilege_by_module_action("ProductUnit", "view")) {
                echo '<li><a href="product_sales_report.php">Product Sales Report</a></li>';
                echo '<li><a href="package_sales_report.php">Package Sales Report</a></li>';
                echo '<li><a href="service_code_report.php">Service Code Report</a></li>';
                echo '<li><a href="colour_code_report.php">Colour Code Report</a></li>';
              }
              ?>
            </ul>
          </li>

          <li>
            <a>
              <i class="fa fa-users" aria-hidden="true"></i>Warehouse Registration <span class="fa fa-chevron-down"></span>
            </a>
            <ul class="nav child_menu">
              <?php
              if(Functions::check_privilege_by_module_action("StockReceive", "view")) {
                echo '<li><a href="stock_receive.php">Warehouse Stock In</a></li>';
              }
              if(Functions::check_privilege_by_module_action("StockProductSales", "view")) {
                echo '<li><a href="stock_product_sales.php">Stock Product Sales</a></li>';
              }
              if(Functions::check_privilege_by_module_action("StockProductUsage", "view")) {
                echo '<li><a href="stock_product_usage.php">Stock Product Usage</a></li>';
              }
              if(Functions::check_privilege_by_module_action("StockWriteOffSales", "view")) {
                echo '<li><a href="stock_write_off_sales.php">Stock Writeoff Sales</a></li>';
              }
              if(Functions::check_privilege_by_module_action("StockWriteOffUsage", "view")) {
                echo '<li><a href="stock_write_off_usage.php">Stock Writeoff Usage</a></li>';
              }
              if(Functions::check_privilege_by_module_action("StockRotateSales", "view")) {
                echo '<li><a href="stock_rotate_sales.php">Stock Rotate Sales</a></li>';
              }
              if(Functions::check_privilege_by_module_action("StockRotateUsage", "view")) {
                echo '<li><a href="stock_rotate_usage.php">Stock Rotate Usage</a></li>';
              }
              if(Functions::check_privilege_by_module_action("StockTransfer", "view")) {
                echo '<li><a href="stock_transfer.php">Stock Transfer (Branch)</a></li>';
              }
              ?>
            </ul>
          </li>

          <li>
            <a>
              <i class="fa fa-users" aria-hidden="true"></i>Customer Report <span class="fa fa-chevron-down"></span></a>
              <ul class="nav child_menu">
                <?php
                  echo '<li><a href="cancelled_bill_report.php">Cancelled Bill Report </a></li>';
                  echo '<li><a href="customer_total_spend_report.php">Customer Total Spend Report </a></li>';
                ?>
              </ul>
          </li>

          <li>
            <a>
              <i class="fa fa-users" aria-hidden="true"></i>Warehouse Report <span class="fa fa-chevron-down"></span></a>
              <ul class="nav child_menu">
                <?php

                // echo '<li><a href="overview_report.php">Overview Report</a></li>';
                // echo '<li><a href="overview_report_branch.php">Overview Report Branch</a></li>';
                // echo '<li><a href="stock_in.php">Stock In Product Sales </a></li>';
                // echo '<li><a href="stock_in_product_used.php">Stock In Product Used </a></li>';
                echo '<li><a href="warehouse_overview_report.php">Warehouse Overview </a></li>';

                echo '<li><a href="stock_write_off_report.php">Stock Write Off Report </a></li>';
                echo '<li><a href="stock_rotate_report.php">Stock Rotate Report </a></li>';
                echo '<li><a href="stock_transfer_report.php">Stock Transfer Report </a></li>';

                echo '<li><a href="branch_product_sales_report.php">Branch Product Sales Report </a></li>';
                echo '<li><a href="branch_product_used_report.php">Branch Product Used Report </a></li>';
                echo '<li><a href="colour_product_used_report.php">Colour Product Used Report </a></li>';
                ?>
              </ul>
          </li>

          <li><a><i class="fa fa-list" aria-hidden="true"></i>Accounts<span class="fa fa-chevron-down"></span></a>
              <ul class="nav child_menu">
                <?php
                // if(Functions::check_privilege_by_module_action("Daily Overall Sales Report","view")){
                  echo '<li><a href="daily_summary.php">Invoice Report</a></li>';
                // }
                ?>
              </ul>
          </li>

          <li>
            <a>
              <i class="fa fa-users" aria-hidden="true"></i>Employee <span class="fa fa-chevron-down"></span></a>
              <ul class="nav child_menu">
                <?php
                echo '<li><a href="position.php">Position </a></li>';
                ?>
              </ul>
          </li>

        </ul>
      </div>
    </div>
    <div class="sidebar-footer hidden-small">
      <small style="color:white;">APT Saloon Sdn Bhd.</small>
    </div>
    <!-- /menu footer buttons -->
  </div>
</div>
