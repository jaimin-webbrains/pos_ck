<?php
require_once './../util/initialize.php';
include 'common/upper_content.php';

if (!(isset($_POST["id"]) && $role = Package::find_by_id($_POST["id"]))) {
  $role = new Package();
}
?>

<!--page content-->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3 style="font-weight:800;">Package</h3>
      </div>

      <div class="title_right">

      </div>
    </div>

    <div class="clearfix"></div>

    <?php Functions::output_result(); ?>

    <div class="row">
      <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2 id="title" style="font-weight:700;"><?php echo (empty($role->id)) ? 'Add' : 'Edit'; ?> Package</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <form id="formRole" action="proccess/package_process.php" method="post" class="form-horizontal form-label-left" enctype="multipart/form-data">
              <div class="col-md-12 col-sm-12 col-xs-12">

                <input type="hidden" class="form-control" id="txtId" name="id" value="<?php echo $role->id; ?>" />

                <div class="form-group">
                  <label>Category</label>
                  <select class="form-control" name="category">
                    <?php
                    foreach (ServiceCategory::find_all() as $status_data ) {
                      echo "<option value='".$status_data->id."'>".$status_data->name."</option>";
                    }

                    ?>

                  </select>
                </div>

                <div class="form-group">
                  <label>Name</label>
                  <small style="color:red;">* Maximum number of Characters: 60 </small>
                  <input type="text" class="form-control" maxlength="60" placeholder="Name" id="txtName" name="name" value="<?php echo $role->name; ?>" required="">
                </div>

                <div class="form-group">
                  <label>Code</label>
                  <small style="color:red;">* Maximum number of Characters: 60 </small>
                  <input type="text" class="form-control" maxlength="60" placeholder="Code" id="txtName" name="code" value="<?php echo $role->code; ?>" onkeyup="showHint(this.value)" required="">
                  <span id="txtHint"></span>
                </div>

                <div class="form-group">
                  <label>Pre Paid Package Price</label>
                  <input type="number" class="form-control" placeholder="Pre Paid Package Price" id="txtName" name="package_price" value="<?php echo $role->package_price; ?>" required="">
                </div>

                <div class="form-group">
                  <label>Expire Date</label>
                  <input type="date" class="form-control" placeholder="Expire Date" id="txtName" name="expire_date" value="<?php echo $role->expire_date; ?>" required="">
                </div>


                <div class="form-group">
                  <label>Qty</label>
                  <input type="number" class="form-control" placeholder="Qty" id="txtName" name="qty" value="<?php echo $role->qty; ?>" required="">
                </div>

                <input type="hidden" class="form-control" placeholder="X Pre Paid Package Sales (%)" id="txtName" name="package_sales" value="0" required="">

                <div class="form-group">
                  <label>OPS1 (%)</label>
                  <input type="number" class="form-control" placeholder="Staff 1 Commision (%)" id="txtName" name="ops_1" value="<?php echo $role->ops_1; ?>" required="">
                </div>

                <div class="form-group">
                  <label>OPS2 (%)</label>
                  <input type="number" class="form-control" placeholder="Staff 2 Commision (%)" id="txtName" name="ops_2" value="<?php echo $role->ops_2; ?>" required="">
                </div>

                <div class="form-group">
                  <div id="divImage" class="col-md-2">
                    <?php
                    $image = "images/user.png";
                    if ($role->image) {
                      $image = "uploads/users/" . $role->image;
                    }
                    ?>
                    <img id="imgImage" src="<?php echo $image; ?>" alt=":( image not found..!" class="image img-responsive img-thumbnail">
                  </div>
                  <div class="col-md-10">
                    <label> Package Image</label>
                    <input id="inpFile" type="file" name="files_to_upload" />
                  </div>
                  <!--                                    <div class="col-md-10">
                  <button id="btnClearImage" type="button" class="btn btn-block btn-default"><i class="fa fa-close"></i> Clear</button>
                </div>-->
              </div>

              <div class="form-group">
                <label>Branch</label>
                <br>
                <label><input type="checkbox" id="select-all" name="all_b"> All</label>
                <br/>


                 <?php

                foreach (Branch::find_all() as $package_data) {

                  $check = PackageBranch::find_by_package_branch($package_data->id,$role->id);
                  if(count($check) > 0){
                     ?>

                  <label><input type="checkbox" class="checkbox_branch" name="<?php echo $package_data->id; ?>" checked> <?php echo $package_data->name; ?></label>
                  <?php
                  }
                  else{
                     ?>
                   <label><input type="checkbox" class="checkbox_branch" name="<?php echo $package_data->id; ?>"> <?php echo $package_data->name; ?></label>
                  <?php
                  }


                }
                ?>

              </div>


              <div class="modal-footer col-md-12 col-sm-12 col-xs-12">
                <?php if(Functions::check_privilege_by_module_action("Package","ins")){ ?>
                  <div class=" col-md-4 col-sm-4 col-xs-12">
                    <!--<button id="btnSave" type="submit" name="save" class="btn btn-block btn-success" onclick="return validateForm()"><i class="fa fa-floppy-o"></i> Save</button>-->
                    <button id="btnSave" type="button" name="save" class="btn btn-block btn-success"><i class="fa fa-floppy-o"></i> Save</button>
                  </div>
                <?php } ?>
                <?php if(Functions::check_privilege_by_module_action("Package","del")){ ?>
                  <div class=" col-md-4 col-sm-4 col-xs-12" style="display: <?php echo (empty($role->id)) ? 'none' : 'initial'; ?>">
                    <!--<button id="btnDelete" type="submit" name="delete" class="btn btn-block btn-danger" onclick="return confirmDelete(this);"><i class="fa fa-trash"></i> Delete</button>-->
                    <button id="btnDelete" type="button" name="delete" class="btn btn-block btn-danger" ><i class="fa fa-trash"></i> Delete</button>
                  </div>
                <?php } ?>
                <div class=" col-md-4 col-sm-4 col-xs-12">
                  <a href="package.php"><button type="button" name="reset" class="btn btn-block btn-primary"><i class="fa fa-history"></i> Reset</button></a>
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
          <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>S/N</th>
                <th>Category</th>
                <th>Name</th>
                <th>Code</th>
                <th>Pre Paid Package Price</th>
                <th>Expire Date</th>
                <th>Qty</th>
                <th>OPS1 (%)</th>
                <th>OPS2 (%)</th>
                <th>Image</th>
                <th>Branch</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>

              <?php

              // $total_records = Package::row_count();
              // $pagination = new Pagination($total_records);
              // $objects = Package::find_all_by_limit_offset($pagination->records_per_page, $pagination->offset());
              $objects = Package::find_all();
              $count = 0;
              foreach ($objects as $role_data) {
                ++$count;
                ?>
                <tr>
                  <td><?php echo $count ?></td>
                  <td><?php echo $role_data->category()->name ?></td>
                  <td><?php echo $role_data->name ?></td>
                  <td><?php echo $role_data->code ?></td>
                  <td><?php echo $role_data->package_price ?></td>
                  <td><?php echo $role_data->expire_date ?></td>
                  <td><?php echo $role_data->qty ?></td>
                  <td><?php echo $role_data->ops_1 ?></td>
                  <td><?php echo $role_data->ops_2 ?></td>
                  <td><?php  $image = "images/user.png";
                  if ($role_data->image) {
                    $image = "uploads/users/" . $role_data->image;
                  } ?> <img id="imgImage" src="<?php echo $image; ?>" alt=":( image not found..!" class="image img-responsive img-thumbnail" style="width: 60px">
                </td>

                <td><?php

                foreach(PackageBranch::find_by_package_id($role_data->id) as $package_branch_data ){
                  echo $package_branch_data->branch_id()->name." / ";                                      }

                  ?></td>

                  <td>
                    <form action="package.php" method="post" style="float: left;">
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
          // echo $pagination->get_pagination_links_html1("package.php");
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
    xmlhttp.open("GET", "proccess/data_check.php?check_package_code=" + str, true);
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
  var id = <?php echo ($role->id) ? 1 : 0; ?>;

  if (id) {
    if (UserPrivileges.checkPrivilege("proccess/privileges_authenticate.php", "Package", "upd")) {
      FormOperations.confirmSave(validateForm(), "#formRole", id, null);
    }
  } else {
    if (UserPrivileges.checkPrivilege("proccess/privileges_authenticate.php", "Package", "ins")) {
      FormOperations.confirmSave(validateForm(), "#formRole", id, null);
    }
  }
});

$("#btnDelete").click(function () {

  if (UserPrivileges.checkPrivilege("proccess/privileges_authenticate.php", "Package", "del")) {
    FormOperations.confirmDelete("#formRole");
  }
});
document.getElementById('select-all').onclick = function() {
  var checkboxes = document.getElementsByClassName('checkbox_branch');
  for (var checkbox of checkboxes) {
    checkbox.checked = this.checked;
  }
}
</script>