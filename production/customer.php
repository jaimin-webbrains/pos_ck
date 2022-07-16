<?php
require_once './../util/initialize.php';
include 'common/upper_content.php';

if (!(isset($_POST["id"]) &&$customer = Customer::find_by_id($_POST["id"]))) {
  $customer = new Customer();
}
?>

<!--page content-->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3 style="font-weight:800;">Customer </h3>
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
            <h2 id="title" style="font-weight:700;"><?php echo (empty($customer_status->id)) ? 'Add' : 'Edit'; ?> Customer </h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <form id="formRole" action="proccess/customer_process.php" method="post" class="form-horizontal form-label-left" >
              <div class="col-md-12 col-sm-12 col-xs-12">
                <input type="hidden" class="form-control" id="txtId" name="id" value="<?php echo$customer->id; ?>" />

                <div class="form-group">
                  <label>Full Name</label>
                  <small style="color:red;">* Maximum number of Characters: 60 </small>
                  <input type="text" maxlength="60" class="form-control" placeholder="Full Name" id="txtName" name="full_name" value="<?php echo$customer->full_name; ?>" autofocus required="">
                </div>

                <div class="form-group">
                  <label>Mobile Number</label>
                  <input type="text" class="form-control" placeholder="Mobile Number" id="txtName" name="mobile" onkeyup="showHint(this.value)" value="<?php echo$customer->mobile; ?>" required="">
                  <span id="txtHint"></span>
                </div>

                <div class="form-group">
                  <label>Email </label>
                  <input type="text" class="form-control" placeholder="Email" id="txtName" name="email" onkeyup="showHintTwo(this.value)" value="<?php echo$customer->email; ?>" required="">
                  <span id="txtHint2"></span>
                </div>

                <div class="form-group">
                  <label>Social Link</label>
                  <input type="text" class="form-control" placeholder="Social Link" id="txtName" name="social_link" value="<?php echo$customer->social_link; ?>" required="">
                </div>

                <div class="form-group">
                  <label>Date of Birth</label>
                  <input type="date" class="form-control" placeholder="Date of Birth" id="txtName" name="dob" value="<?php echo$customer->dob; ?>" required="">
                </div>


                <input type="hidden" class="form-control" name="join_date" value="<?php echo date('Y-m-d'); ?>" required="">

                <div class="form-group">
                  <label>Refered By</label>
                  <select name="refered_by" class="form-control">
                    <option value="0" selected> NO REFERENCE </option>
                    <?php
                    foreach( Customer::find_all() as $customer_data ){
                      echo "<option value='".$customer_data->id."'>".$customer_data->full_name."</option>";
                    }
                    ?>
                  </select>
                </div>

                <div class="form-group">
                  <label>Customer Status</label>
                  <select class="form-control" name="customer_status">
                    <?php
                    foreach (CustomerStatus::find_all() as $status_data ) {
                      echo "<option value='".$status_data->id."'>".$status_data->name."</option>";
                    }

                    ?>

                  </select>
                </div>


                <div class="modal-footer col-md-12 col-sm-12 col-xs-12">
                  <?php if(Functions::check_privilege_by_module_action("Customer","ins")){ ?>
                    <div class=" col-md-4 col-sm-4 col-xs-12">
                      <!--<button id="btnSave" type="submit" name="save" class="btn btn-block btn-success" onclick="return validateForm()"><i class="fa fa-floppy-o"></i> Save</button>-->
                      <button id="btnSave" type="button" name="save" class="btn btn-block btn-success"><i class="fa fa-floppy-o"></i> Save</button>
                    </div>
                  <?php } ?>
                  <?php if(Functions::check_privilege_by_module_action("Customer","del")){ ?>
                    <div class=" col-md-4 col-sm-4 col-xs-12" style="display: <?php echo (empty($customer->id)) ? 'none' : 'initial'; ?>">
                      <!--<button id="btnDelete" type="submit" name="delete" class="btn btn-block btn-danger" onclick="return confirmDelete(this);"><i class="fa fa-trash"></i> Delete</button>-->
                      <button id="btnDelete" type="button" name="delete" class="btn btn-block btn-danger" ><i class="fa fa-trash"></i> Delete</button>
                    </div>
                  <?php } ?>
                  <div class=" col-md-4 col-sm-4 col-xs-12">
                    <a href="customer.php"><button type="button" name="reset" class="btn btn-block btn-primary"><i class="fa fa-history"></i> Reset</button></a>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>

      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2 id="title" style="font-weight:700;"> Management</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <table id="" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Full Name</th>
                  <th>Mobile Number</th>
                  <th>Email</th>
                  <th>Social Link</th>
                  <th>Date of Birth</th>
                  <th>Join Date</th>
                  <th>Customer Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

                <?php

                // $total_records = Customer::row_count();
                // $pagination = new Pagination($total_records);
                // $objects = Customer::find_all_by_limit_offset($pagination->records_per_page, $pagination->offset());
                $objects = Customer::find_all();

                foreach ($objects as $role_data) {
                  ?>
                  <tr>
                    <td><?php echo $role_data->id ?></td>
                    <td><?php echo $role_data->full_name ?></td>
                    <td><?php echo $role_data->mobile ?></td>
                    <td><?php echo $role_data->email ?></td>
                    <td><?php echo $role_data->social_link ?></td>
                    <td><?php echo $role_data->dob ?></td>
                    <td><?php echo $role_data->join_date ?></td>
                    <td><?php echo $role_data->customer_status()->name ?></td>



                    <td>
                      <form action="customer.php" method="post" style="float: left;">
                        <input type="hidden" name="id" value="<?php echo $role_data->id ?>"/>
                        <button type="submit" name="view" class="btn btn-primary btn-xs" ><i class="glyphicon glyphicon-edit"></i> Edit</button>
                      </form>

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

// exsisting check start
function showHint(str) {
  if (str.length == 0) {
    document.getElementById("txtHint").innerHTML = "";
    return;
  } else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("txtHint").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET", "proccess/data_check.php?customer_contact=" + str, true);
    xmlhttp.send();
  }
}
// existing check ends

// exsisting check start
function showHintTwo(str) {
  if (str.length == 0) {
    document.getElementById("txtHint2").innerHTML = "";
    return;
  } else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("txtHint2").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET", "proccess/data_check.php?customer_email=" + str, true);
    xmlhttp.send();
  }
}
// existing check ends

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
  var id = <?php echo ($customer->id) ? 1 : 0; ?>;

  if (id) {
    if (UserPrivileges.checkPrivilege("proccess/privileges_authenticate.php", "Customer", "upd")) {
      FormOperations.confirmSave(validateForm(), "#formRole", id, null);
    }
  } else {
    if (UserPrivileges.checkPrivilege("proccess/privileges_authenticate.php", "Customer", "ins")) {
      FormOperations.confirmSave(validateForm(), "#formRole", id, null);
    }
  }
});

$("#btnDelete").click(function () {

  if (UserPrivileges.checkPrivilege("proccess/privileges_authenticate.php", "Customer", "del")) {
    FormOperations.confirmDelete("#formRole");
  }
});
</script>
