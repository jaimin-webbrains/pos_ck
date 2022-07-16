<?php
require_once './../util/initialize.php';
include 'common/upper_content.php';
?>

<!--page content-->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3 style="font-weight:800;">Invoice Deleted</h3>
      </div>

      <div class="title_right">

      </div>
    </div>

    <div class="clearfix"></div>

    <?php Functions::output_result(); ?>

    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2 id="title" style="font-weight:700;"> Invoice Deleted</h2>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead>
              <tr>
              <th>S/N</th>
              <th>Invoice ID</th>
              <th>Invoice Number</th>
              <th>Invoice Date</th>
              <th>Customer Name</th>
              <th style='text-align:center;'>Invoice Branch</th>
              <th style='text-align:right;'>OPS1 COUNT</th>
              <th style='text-align:right;'>OPS1 COUNT</th>
              </tr>
            </thead>
            <tbody>

              <?php
              $objects = InvoiceDelete::find_all();
              $count = 0;
              foreach ($objects as $role_data) {
                ++$count;
                ?>
                <tr>
                  <td><?php echo $count ?></td>
                  <td><?php echo $role_data->invoice_id ?></td>
                  <td><?php echo $role_data->invoice_number ?></td>
                  <td><?php echo $role_data->invoice_date ?></td>
                  <td><?php echo $role_data->customer_id()->full_name ?></td>
                  <td><?php echo $role_data->invoice_branch()->name; ?></td>
                  <?php
                    $head_count = 1;
                    foreach(InvoiceSub::find_all_invoice_id($role_data->invoice_id) as $sub_invoice_data){
                      if( $sub_invoice_data->ops2 > 0 ){
                        $head_count = 0.5;
                      }
                    }
                    if($head_count == 1){
                      echo "<td style='text-align:right;'> 1 </td>";
                      echo "<td style='text-align:right;'> 0 </td>";
                    }else{
                      echo "<td style='text-align:right;'> 0.5 </td>";
                      echo "<td style='text-align:right;'> 0.5 </td>";
                    }
                  ?>
                </tr>
                <?php
              }
              ?>

            </tbody>
          </table>
        </div>
      </div>
   
    </div>


  </div>
</div>
</div>
<!--/page content-->
<?php include 'common/bottom_content.php'; ?> bottom content

