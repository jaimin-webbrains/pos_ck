<?php
require_once './../util/initialize.php';
include 'common/upper_content.php';
?>

<!--page content-->
<div class="right_col" role="main">
  <div class="">

    <?php Functions::output_result(); ?>

    <div class="row">
      <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2 id="title" style="font-weight:700;"> - REWARD POINT CHECK - </h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <form id="formRole" action="reward_point.php" method="post" class="form-horizontal form-label-left" >
              <div class="col-md-12 col-sm-12 col-xs-12">
                <input type="hidden" class="form-control" id="txtId" name="id" value="<?php echo $role->id; ?>" />
                <div class="form-group">
                  <label>Customer Name: </label>
                  <select class="form-control customer_select" name="customer_id">
                    <?php
                    // foreach(Customer::find_all() as $customer_data){
                    //   echo "<option value='".$customer_data->id."'>".$customer_data->full_name." - ".$customer_data->mobile." - ".$customer_data->email."</option>";
                    // }
                    ?>
                  </select>
                </div>
                <div class="modal-footer col-md-12 col-sm-12 col-xs-12">
                    <div class=" col-md-4 col-sm-4 col-xs-12">
                      <button id="btnSave" type="submit" name="save" class="btn btn-block btn-success"><i class="fa fa-floppy-o"></i> Save</button>
                    </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- SECOND COLUMN -->

      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2 id="title" style="font-weight:700;"> - REWARD POINTS - </h2>
              <button class="btn btn-primary" style="float:right" onclick="exportTableToExcel('report_table')">Export Table</button>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <!-- table starts -->

            <table class="table table-hover" id="report_table" style="width:100%;">
              <thead>
                <tr>
                  <th>Reffered By</th>
                  <th>Added Date</th>
                  <th>Bill Number</th>
                  <th>Service Item </th>
                  <th>Total Price  </th>
                  <th>Points</th>
                  <th>Stylist </th>
                </tr>
              </thead>
              <tbody>

                <?php
                $total = 0;
                $total_amount = 0;
                if( isset($_POST['customer_id']) ){
                  $total = 0;
                  $total_amount = 0;
                  foreach(RewardPoint::find_all_by_customer_id($_POST['customer_id']) as $points ){
                    echo "<tr>";
                    if($points->referal_id != NULL){
                      echo "<td>".$points->referal_id()->full_name."</td>";
                    }else{
                      echo "<td> Direct </td>";
                    }
                    
                    echo "<td>".$points->reward_date."</td>";
                    $invoice = Reports :: get_invoice_by_id($points->invoice_id);
                    if($invoice){
                      echo "<td>".$invoice[0]->invoice_number."</td>";
                    }else{
                       echo "<td>-</td>";
                    }

                    $invoice_sub = InvoiceSub::find_all_invoice_id($points->invoice_id);
                    $services = '';
                    if($invoice_sub){
                      foreach($invoice_sub as $inv){
                          if($services == ''){
                              $services .= $inv->name;
                          }else{
                              $services .= ','.$inv->name;
                          }
                      }
                    }

                    echo "<td>".$services."</td>";

                    if($invoice){
                      echo "<td>".$invoice[0]->invoice_total."</td>";
                      $total_amount += $invoice[0]->invoice_total;
                    }else{
                       echo "<td>-</td>";
                    }
                    
                    echo "<td>".$points->reward_points."</td>";
                    echo "<td>  </td>";
                    $total = $total + $points->reward_points;
                    echo "</tr>";
                  }

                }
                ?>

                <tr>
                  <td colspan="4" style="text-align:right;font-size:20px;font-weight:700;">TOTAL</td>
                  <td style="text-align:right;font-size:20px;font-weight:700;"><?php echo number_format($total_amount,2); ?></td>
                  <td style="text-align:right;font-size:20px;font-weight:700;"><?php echo number_format($total,2); ?></td>
                </tr>
              </tbody>
            </table>

            <!-- table ends -->
          </div>
        </div>
      </div>



    </div>
  </div>
</div>
<!--/page content-->
<?php include 'common/bottom_content.php'; ?> bottom content
<script type="text/javascript">
  function exportTableToExcel(tableID, filename = '') {
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';
    // Create download link element
    downloadLink = document.createElement("a");
    document.body.appendChild(downloadLink);
    if(navigator.msSaveOrOpenBlob){
      var blob = new Blob(['\ufeff', tableHTML], {
        type: dataType
      });
      navigator.msSaveOrOpenBlob( blob, filename);
    }else{
      // Create a link to the file
      downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

      // Setting the file name
      downloadLink.download = filename;

      //triggering the function
      downloadLink.click();
    }
  }

  $('.customer_select').select2({
    ajax: {
        url :"reward_point_check.php",
        dataType: "json",
        type: "GET",
        data: function (params) {
            var queryParameters = {
                search: params.term,
            }
            return queryParameters;
        },
        processResults: function (data, params) {
            params.page = params.page || 1;
            return {
                results: $.map(data, function (item) {
                    return {
                        text: item.full_name + ' ' + item.mobile + ' ' + item.email,
                        id: item.id
                    }
                }),
                pagination: {
                    more: (params.page * 30) < data.total_count
                }
            };
        },
        cache: true,
    },
    placeholder: 'Select',
    minimumInputLength: 4
});
</script>
