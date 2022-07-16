<?php
require_once './../util/initialize.php';
include 'common/upper_content.php';
?>

<!--page content-->
<div class="right_col" role="main">
  <div class="">

    <?php Functions::output_result(); ?>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2 id="title" style="font-weight:700;"> - BIRTHDAY VOUCHER (BY MONTH) - </h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <!-- contnt start -->

            <!-- contnt ends -->
          </div>
        </div>
      </div>

      <!-- SECOND ROW -->

        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_content">

              <!-- form start -->
              <form action="proccess/voucher_process.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="email">MESSAGE</label>
                  <textarea name="voucher_message" rows="8" class="form-control"></textarea>
                </div>
                <div class="form-group">
                  <label for="pwd">VOUCHER VALUE:</label>
                  <input type="number" name="voucher_value" class="form-control" id="pwd">
                </div>
                <div class="form-group">
                  <label for="voucher_value_type">VOUCHER VALUE TYPE:</label>
                  <select name="voucher_value_type" id="voucher_value_type" class="form-control">
                    <option value="1">Flat</option>
                    <option value="0">Percentage</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="pwd">BACKGROUND IMAGE:</label>
                  <input id="inpFile" type="file" name="files_to_upload" />
                </div>

              <!-- table start -->

              <table id="example" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>Customer Name</th>
                    <th style='text-align:right;'><label><input type="checkbox" id="select-all" value=""> SELECT ALL</label></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $this_month = date('m');
                  foreach(Customer::find_all_customer_birthday($this_month) as $cus_data){
                    echo "<tr>";
                    echo "<td>".$cus_data->full_name."</td>";
                    echo "<td style='text-align:right;'>";
                    echo '<div class="form-group">
                    <div class="checkbox">
                    <label><input type="checkbox" name="cus'.$cus_data->id.'" value="1"> SELECT</label>
                    </div>
                    </div>';
                    echo "</td>";
                    echo "</tr>";
                  }
                  ?>
                </tbody>
              </table>

              <!-- table ends -->

              <hr/>

              <button type="submit" name="birthday" class="btn btn-primary btn-block">SEND </button>
            </form>
            <!-- form ends -->

            </div>
          </div>
        </div>

    </div>
  </div>
</div>
<!--/page content-->
<?php include 'common/bottom_content.php'; ?> bottom content
<script>

$(document).ready(function() {
  $('#example').DataTable( {
    "paging":   false,
    "order": [[ 1, "desc" ]]
  } );
} );

$(document).ready(function() {
  $('#select-all').click(function() {
    var checked = this.checked;
    $('input[type="checkbox"]').each(function() {
      this.checked = checked;
    });
  })
});

</script>
