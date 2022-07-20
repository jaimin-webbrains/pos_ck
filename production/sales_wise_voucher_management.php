<?php
require_once './../util/initialize.php';
include 'common/upper_content.php';

if (!(isset($_POST["id"]) && $role = NewsTicker::find_by_id($_POST["id"]))) {
  $role = new NewsTicker();
}
?>

<!--page content-->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3 style="font-weight:800;">VOUCHER MANAGEMENT </h3>
      </div>

      <div class="title_right">

      </div>
    </div>

    <div class="clearfix"></div>

    <?php Functions::output_result(); ?>

    <div class="row">

      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2 id="title" style="font-weight:700;"> Management</h2>
            <a href="sales_wise_voucher_management_print.php" style="float:right" target="_blank" class="btn btn-primary">Export Data</a>
            <div class="clearfix"></div>
          </div>
		  
          <div class="x_content">
            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"  cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>Voucher Date</th>
                  <th>Voucher Number</th>
                  <th>Voucher Type</th>
                  <th style="text-align:center;">Voucher Message</th>
                  <th style="text-align:center;">Voucher Value</th>
                  <th style="text-align:center;">Background Image</th>
                  <th style="text-align:center;">Customer Name</th>
                  <th style="text-align:center;">Action</th>
                </tr>
              </thead>
              <tbody>

                <?php
                // $objects = Voucher::find_all_desc();

                $total_records = Voucher::row_count();
                $pagination = new Pagination($total_records);
                $objects = Voucher::find_all_by_limit_offset($pagination->records_per_page, $pagination->offset());
                foreach ($objects as $data) {
                  // echo '<pre>';
                  // print_r($data);
                  ?>
                  
                  
                  <tr>
                    <td><?php echo $data->voucher_date; ?></td>
                    <td style="text-align:center;"><?php echo $data->voucher_number; ?></td>
                    <?php
                    if($data->voucher_type == 1){
                      echo "<td>Voucher For Sales Wise</td>";
                    }else if($data->voucher_type == 2){
                      echo "<td>Voucher For Birthday Month</td>";
                    }else if($data->voucher_type == 3){
                      echo "<td>Voucher For Joined Month</td>";
                    }else if($data->voucher_type == 4){
                      echo "<td>Voucher For Selected Customer</td>";
                    }else{
                      echo "<td style='text-align:center;'>-</td>";
                    }
                    ?>
                    <?php if(!empty($data->voucher_message)){ ?>
                    <td style="text-align:center;"><?php echo $data->voucher_message; ?></td>
                    <?php }else{ ?>
                      <td style="text-align:center;"></td>
                    <?php } ?>
                    <td style="text-align:center;"><?php echo $data->voucher_value; ?></td>
                    <?php if(!empty($data->voucher_background_image)){ ?>
                      <td style="text-align:center;"><img src='../production/uploads/users/<?php echo $data->voucher_background_image; ?>' style="width:100px;" /></td>
                    <?php }else{ ?>
                      <td style="text-align:center;"></td>
                    <?php } ?>
                    
                    <td style="text-align:center;"><?php echo $data->customer_id()->full_name; ?></td>
                    <td style="text-align:center;">
                      <a href="voucher_preview.php?id=<?php echo $data->id; ?>" class="btn btn-xs btn-primary" target="_blank"> VIEW VOUCHER </a>
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
            <?php
              echo $pagination->get_pagination_links_html1("sales_wise_voucher_management.php");
            ?>
          </div>

        </div>
      </div>

    </div>
  </div>
</div>
<!--/page content-->
<?php include 'common/bottom_content.php'; ?> bottom content
<script>

</script>
