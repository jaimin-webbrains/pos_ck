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

        <div class="col-sm-6"> <a href="invoice_print.php?invoice_id=<?php echo $_GET['invoice_id']; ?>" target="_blank" onclick="Myfunction()" class="btn btn-primary btn-block touch-button b1" role="button"> <i class="fa fa-print" aria-hidden="true" style="font-size:50px;"></i> <br/><br/> PRINT INVOICE</a> </div>
        <div class="col-sm-6"> <a href="invoice_print.php?invoice_id=<?php echo $_GET['invoice_id']; ?>" target="_blank" onclick="Myfunction()" class="btn btn-primary btn-block touch-button b1" role="button"> <i class="fa fa-address-card" aria-hidden="true" style="font-size:50px;"></i> <br/><br/> EMAIL AND VIEW</a> </div>

        <!-- end of invoice type selector -->
      </div>
    </div>

  </div>
</div>

</form>
<!-- content container ends -->
</body>

  <script>
  function Myfunction(){
    window.location.href = "invoice_type.php";
  }
  </script>

</html>
