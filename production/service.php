<?php
require_once './../util/initialize.php';
include 'common/upper_content.php';

if (!(isset($_POST["id"]) && $role = Service::find_by_id($_POST["id"]))) {
  $role = new Service();
  // echo '<pre>';
  // print_r($role);
  // die;
}
?>

<!--page content-->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3 style="font-weight:800;">Services</h3>
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
            <h2 id="title" style="font-weight:700;"><?php echo (empty($role->id)) ? 'Add' : 'Edit'; ?> Services</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <form id="formRole" action="proccess/service_process.php" method="post" class="form-horizontal form-label-left" enctype="multipart/form-data">
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
                  <label>Price</label>
                  <input type="number" class="form-control" placeholder="Price" id="txtName" name="price" value="<?php echo $role->price; ?>" required="">
                </div>

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
                    <label> Service Image</label>
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

                foreach (Branch::find_all() as $branch_data) {

                  $check = ServiceBranch::find_by_service_branch($branch_data->id,$role->id);
                  if(count($check) > 0){
                     ?>

                  <label><input type="checkbox" class="checkbox_branch" name="<?php echo $branch_data->id; ?>" checked><?php echo $branch_data->name; ?></label>
                  <?php
                  }
                  else{
                     ?>
                  <label><input type="checkbox" class="checkbox_branch" name="<?php echo $branch_data->id; ?>" > <?php echo $branch_data->name; ?></label>
                  <?php
                  }


                }
                ?>

              </div>

              <div class="modal-footer col-md-12 col-sm-12 col-xs-12">
                <?php if(Functions::check_privilege_by_module_action("Service_Category","ins")){ ?>
                  <div class=" col-md-4 col-sm-4 col-xs-12">
                    <!--<button id="btnSave" type="submit" name="save" class="btn btn-block btn-success" onclick="return validateForm()"><i class="fa fa-floppy-o"></i> Save</button>-->
                    <button id="btnSave" type="button" name="save" class="btn btn-block btn-success"><i class="fa fa-floppy-o"></i> Save</button>
                  </div>
                <?php } ?>
                <?php if(Functions::check_privilege_by_module_action("Service_Category","del")){ ?>
                  <div class=" col-md-4 col-sm-4 col-xs-12" style="display: <?php echo (empty($role->id)) ? 'none' : 'initial'; ?>">
                    <!--<button id="btnDelete" type="submit" name="delete" class="btn btn-block btn-danger" onclick="return confirmDelete(this);"><i class="fa fa-trash"></i> Delete</button>-->
                    <button id="btnDelete" type="button" name="delete" class="btn btn-block btn-danger" ><i class="fa fa-trash"></i> Delete</button>
                  </div>
                <?php } ?>
                <div class=" col-md-4 col-sm-4 col-xs-12">
                  <a href="service.php"><button type="button" name="reset" class="btn btn-block btn-primary"><i class="fa fa-history"></i> Reset</button></a>
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
          <h2 id="title" style="font-weight:700;"> Service</h2>
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
                <th>Price</th>
                <th>OPS1 (%)</th>
                <th>OPS2 (%)</th>
                <th>Image</th>
                <th>Branch</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>

              <?php

              // $total_records = Service::row_count();
              // $pagination = new Pagination($total_records);
              // $objects = Service::find_all_by_limit_offset($pagination->records_per_page, $pagination->offset());
              $objects = Service::find_all();
              $count = 0;
              foreach ($objects as $role_data) {
                ++$count;
                ?>
                <tr>
                  <td><?php echo $count ?></td>
                  <td><?php echo $role_data->category()->name ?></td>
                  <td><?php echo $role_data->name ?></td>
                  <td><?php echo $role_data->code ?></td>
                  <td><?php echo $role_data->price ?></td>
                  <td><?php echo $role_data->ops_1 ?></td>
                  <td><?php echo $role_data->ops_2 ?></td>
                  <td><?php  $image = "images/user.png";
                  if ($role_data->image) {
                    $image = "uploads/users/" . $role_data->image;
                  } ?> <img id="imgImage" src="<?php echo $image; ?>" alt=":( image not found..!" class="image img-responsive img-thumbnail" style="width: 60px">
                </td>

                <td><?php

                foreach(ServiceBranch::find_by_service_id($role_data->id) as $service_branch_data ){
                  echo $service_branch_data->branch_id()->name." / ";                                      }

                  ?></td>

                  <td>
                    <form action="service.php" method="post" style="float: left;">
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
          // echo $pagination->get_pagination_links_html1("service.php");
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
    xmlhttp.open("GET", "proccess/data_check.php?check_service_code=" + str, true);
    xmlhttp.send();
  }
}
// existing check ends

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
    if (UserPrivileges.checkPrivilege("proccess/privileges_authenticate.php", "Service", "upd")) {
      FormOperations.confirmSave(validateForm(), "#formRole", id, null);
    }
  } else {
    if (UserPrivileges.checkPrivilege("proccess/privileges_authenticate.php", "Service", "ins")) {
      FormOperations.confirmSave(validateForm(), "#formRole", id, null);
    }
  }
});

$("#btnDelete").click(function () {

  if (UserPrivileges.checkPrivilege("proccess/privileges_authenticate.php", "Service", "del")) {
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
