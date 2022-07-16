<?php
require_once './../util/initialize.php';
require_once 'common/pos_header.php';
$user = User::find_by_id($_SESSION["user"]["id"]);
?>
<style media="screen">
.b1{
  font-weight: 700;
}
</style>
<body>
  <!-- content container starts -->
  <div class="container-fluid">
    <div class="row" id='info-bar'>
      <div class="col-sm-8">

        <table class="table table-bordered">
          <tbody>
            <tr>
              <td colspan=2 >LOGGEDIN USER: <?php echo $user->name; ?> || Branch Name: <?php
              $branch = Branch::find_by_id($user->branch_id);
              echo $branch->name;
              ?> || Code: <?php
              $branch = Branch::find_by_id($user->branch_id);
              echo $branch->code;
              ?></td>
            </tr>
        </tbody>
      </table>

    </div>

    <?php require_once 'common/mini_header.php'; ?>

  </div>
</div>


<div class="container-fluid">
  <div class="row">

    <div class="col-sm-12">
      <div class="col-sm-12" id='bottom-section'>

        <?php Functions::output_result(); ?>

        <!-- invoice type selector -->

        <table class="table">
          <thead>
            <tr>
              <th>s/no</th>
              <th>Name</th>
              <th>Category</th>
              <th>Code</th>
              <th style='text-align:right;'>Unit Price</th>
              <th style='text-align:center;'>Qty</th>
              <th style='text-align:right;'>Sub Total</th>
              <th style='text-align:right;'>OPS1 STAFF</th>
              <th style='text-align:center;'>OPS1</th>
              <th style='text-align:right;'>OPS2 STAFF</th>
              <th style='text-align:center;'>OPS2</th>
              <th style='text-align:center;'>HEAD COUNT</th>
              <!-- <th style='text-align:right;'>OPS1 COUNT</th>
              <th style='text-align:right;'>OPS1 COUNT</th> -->
              <th style='text-align:center;'>ITEM TYPE</th>

            </tr>
          </thead>
          <tbody>
            <?php
            $invoice_id = $_GET['invoice_id'];
            $invoice_data = Invoice::find_by_id($invoice_id);

            $invoice_total = 0;

            $row_count = 1;

            foreach(InvoiceSub::find_all_invoice_id($invoice_id) as $sub_invoice_data){
              echo "<tr>";
              echo "<td>".$row_count."</td>";
              ++$row_count;
              echo "<td>".$sub_invoice_data->name."</td>";
              echo "<td>".$sub_invoice_data->category."</td>";
              echo "<td>".$sub_invoice_data->code."</td>";
              echo "<td style='text-align:right;'>".$sub_invoice_data->unit_price."</td>";
              echo "<td style='text-align:center;'>".$sub_invoice_data->qty."</td>";
              echo "<td style='text-align:right;'>".$sub_invoice_data->sub_total."</td>";
              echo "<td style='text-align:right;'>".$sub_invoice_data->ops1_user()->name."</td>";

              echo "<td style='text-align:center;'>".number_format($sub_invoice_data->ops1,2)."</td>";
              echo "<td style='text-align:right;'>".$sub_invoice_data->ops2_user()->name."</td>";

              echo "<td style='text-align:center;'>".number_format($sub_invoice_data->ops2,2)."</td>";

              // if( $sub_invoice_data->ops2 > 0 ){
              //   echo "<td style='text-align:center;'>0.5</td>";
              //   echo "<td style='text-align:center;'>0.5</td>";
              // }else if( $sub_invoice_data->ops2 == 0 ){
              //   echo "<td style='text-align:center;'>1</td>";
              //   echo "<td style='text-align:center;'>0</td>";
              // }

              if($sub_invoice_data->item_type == 1){
                echo "<td style='text-align:center;'>B</td>";
              }else if($sub_invoice_data->item_type == 2){
                echo "<td style='text-align:center;'>S</td>";
              }else if($sub_invoice_data->item_type == 3){
                echo "<td style='text-align:center;'>P</td>";
              }else if($sub_invoice_data->item_type == 4){
                echo "<td style='text-align:center;'>R</td>";
              }

              echo "</tr>";

              $invoice_total = $invoice_total + $sub_invoice_data->sub_total;

            }

            echo "<tr style='font-size:16px;'>";
            echo "<td style='text-align:right;'> </td>";
            echo "<td style='text-align:left;'>GROSS TOTAL </td>";
            echo "<td style='text-align:left;'> ".number_format($invoice_total,2)." </td>";
            echo "<td style='text-align:left;'>DISCOUNT </td>";
            echo "<td  style='text-align:left;'> ".$invoice_data->invoice_discount."%</td>";

            $discount = 0;
            $net_total = 0;
            $discount = 100 - $invoice_data->invoice_discount;
            $net_total = ($discount * $invoice_total)/100;

            echo "<td colspan='2' style='text-align:right;'>NET TOTAL </td>";
            echo "<td style='text-align:right;'> ".number_format($net_total,2)." </td>";
            echo "<td colspan='6'> </td>";

            ?>
          </tbody>
        </table>

        <!-- end of invoice type selector -->
      </div>
    </div>

  </div>
</div>

</form>
<!-- content container ends -->
</body>
</html>
