<?php
require_once './../util/initialize.php';
include 'common/upper_content.php';

if ( $customer_status = SystemSettings::find_by_id(1) ) {
  // $customer_status = new SystemSettings();
}
?>

<!--page content-->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3 style='font-weight:800;'>Settings</h3>
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
            <h2 id="title" style="font-weight:700;"><?php echo (empty($customer_status->id)) ? 'Add' : 'Edit'; ?> Settings</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <form id="formRole" action="proccess/settings_process.php" method="post" class="form-horizontal form-label-left" >
              <div class="col-md-12 col-sm-12 col-xs-12">
                <input type="hidden" class="form-control" id="txtId" name="id" value="<?php echo $customer_status->id; ?>" />


                <div class="form-group">
                  <label>Point Voucher</label>
                  <input type="text" class="form-control" placeholder="Point Voucher" name="point_voucher" value="<?php echo $customer_status->point_voucher; ?>" required="">
                </div>


                <div class="form-group">
                  <label>Reward Points Factor</label>
                  <input type="text" class="form-control" placeholder="Direct Commision" name="refer_commision" value="<?php echo $customer_status->direct_commision; ?>" required="">
                </div>

                <div class="form-group">
                  <label>Referrer Factor</label>
                  <input type="text" class="form-control" placeholder="Refer Commision" name="direct_commision" value="<?php echo $customer_status->refer_commision; ?>" required="">
                </div>

                <div class="form-group">
                  <label>Expiry Month</label>
                  <input type="text" class="form-control" placeholder="Expiry Month" name="expiry_month" value="<?php echo $customer_status->expiry_month; ?>" required="">
                </div>


                <div class="form-group">
                  <label>Minimum Voucher Point</label>
                  <input type="text" class="form-control" placeholder="Minimum Voucher Point" name="min_voucher_point" value="<?php echo $customer_status->min_voucher_point; ?>" required="">
                </div>

                <div class="form-group">
                  <label>Maximum Voucher Discount Percentage</label>
                  <input type="text" class="form-control" placeholder="Maximum Voucher Discount" name="max_voucher_discount" value="<?php echo $customer_status->max_voucher_discount; ?>" required="">
                </div>

                <div class="form-group">
                  <label>Service</label>
                  <input type="text" class="form-control" placeholder="Service" name="service" value="<?php echo $customer_status->service; ?>" required="">
                </div>

                <div class="form-group">
                  <label>GST</label>
                  <input type="text" class="form-control" placeholder="GST" name="gst" value="<?php echo $customer_status->gst; ?>" required="">
                </div>

                <div class="modal-footer col-md-12 col-sm-12 col-xs-12">
                  <?php if(Functions::check_privilege_by_module_action("Customer_Status","ins")){ ?>
                    <div class=" col-md-4 col-sm-4 col-xs-12">
                      <!--<button id="btnSave" type="submit" name="save" class="btn btn-block btn-success" onclick="return validateForm()"><i class="fa fa-floppy-o"></i> Save</button>-->
                      <button id="btnSave" type="button" name="save" class="btn btn-block btn-success"><i class="fa fa-floppy-o"></i> Save</button>
                    </div>
                  <?php } ?>

                  <div class=" col-md-4 col-sm-4 col-xs-12">
                    <a href="customer_status.php"><button type="button" name="reset" class="btn btn-block btn-primary"><i class="fa fa-history"></i> Reset</button></a>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>



    </div>
  </div>
</div>
<!--/page content-->
<?php include 'common/bottom_content.php'; ?> bottom content
<script>
window.onload = function () {
  //        $.alert({
  //            type: 'red',
  //            title: 'Welcome!',
  //            content: 'Mahesh!',
  //        });
};

function getErrors(){
  var errors = new Array();
  var element;
  var element_value;

  element=$("#txtName");
  element_value=element.val();
  if ( element_value === "") {
    errors.push("Name - Invalid");
    element.css({"border": "1px solid red"});
  }else{
    element.css({"border": "1px solid #ccc"});
  }

  return errors;
}

function validateForm() {
  var errors = getErrors();
  if (errors === undefined || errors.length === 0) {
    return true;
  } else {
    $.alert({
      icon: 'fa fa-exclamation-circle',
      backgroundDismiss: true,
      type: 'red',
      title: 'Validation error!',
      content: errors.join("</br>")
    });
    return false;
  }
}

$("#btnSave").click(function () {
  var id = <?php echo ($customer_status->id) ? 1 : 0; ?>;

  if (id) {
    if (UserPrivileges.checkPrivilege("proccess/privileges_authenticate.php", "Branch", "upd")) {
      FormOperations.confirmSave(validateForm(), "#formRole", id, null);
    }
  } else {
    if (UserPrivileges.checkPrivilege("proccess/privileges_authenticate.php", "Branch", "ins")) {
      FormOperations.confirmSave(validateForm(), "#formRole", id, null);
    }
  }
});

$("#btnDelete").click(function () {

  if (UserPrivileges.checkPrivilege("proccess/privileges_authenticate.php", "Branch", "del")) {
    FormOperations.confirmDelete("#formRole");
  }
});
</script>
