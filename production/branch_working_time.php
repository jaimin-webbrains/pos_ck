<?php
require_once './../util/initialize.php';
include 'common/upper_content.php';

if (!(isset($_POST["id"]) && $data = BranchWorkingTime::find_by_id($_POST["id"]))) {
  $data = new BranchWorkingTime();
}
?>

<!--page content-->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3 style="font-weight:800;">Branch Working Time</h3>
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
            <h2 id="title" style="font-weight:700;"><?php echo (empty($data->id)) ? 'Add' : 'Edit'; ?> Branch Wroking Time </h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <form id="formRole" action="proccess/branch_working_time_process.php" method="post" class="form-horizontal form-label-left" >
              <div class="col-md-12 col-sm-12 col-xs-12">
                <input type="hidden" class="form-control" id="txtId" name="id" value="<?php echo $data->id; ?>" />
                <div class="form-group">
                  <label>Branch</label>
                  <select class="form-control" name="branch_id">
                    <?php
                    foreach(Branch::find_all() as $branch){
                      echo "<option value='".$branch->id."'>".$branch->name."</option>";
                    }
                    ?>
                  </select>
                </div>

                <div class="form-group">
                  <label>From</label>
                  <input type="time" class="form-control" name="start_time" value="<?php echo $data->start_time; ?>" required="">
                </div>

                <div class="form-group">
                  <label>Time</label>
                  <input type="time" class="form-control" name="end_time" value="<?php echo $data->end_time; ?>" required="">
                </div>

                <div class="modal-footer col-md-12 col-sm-12 col-xs-12">
                  <?php if(Functions::check_privilege_by_module_action("Branch","ins")){ ?>
                    <div class=" col-md-4 col-sm-4 col-xs-12">
                      <!--<button id="btnSave" type="submit" name="save" class="btn btn-block btn-success" onclick="return validateForm()"><i class="fa fa-floppy-o"></i> Save</button>-->
                      <button id="btnSave" type="button" name="save" class="btn btn-block btn-success"><i class="fa fa-floppy-o"></i> Save</button>
                    </div>
                  <?php } ?>
                  <?php if(Functions::check_privilege_by_module_action("Branch","del")){ ?>
                    <div class=" col-md-4 col-sm-4 col-xs-12" style="display: <?php echo (empty($data->id)) ? 'none' : 'initial'; ?>">
                      <!--<button id="btnDelete" type="submit" name="delete" class="btn btn-block btn-danger" onclick="return confirmDelete(this);"><i class="fa fa-trash"></i> Delete</button>-->
                      <button id="btnDelete" type="button" name="delete" class="btn btn-block btn-danger" ><i class="fa fa-trash"></i> Delete</button>
                    </div>
                  <?php } ?>
                  <div class=" col-md-4 col-sm-4 col-xs-12">
                    <a href="branch.php"><button type="button" name="reset" class="btn btn-block btn-primary"><i class="fa fa-history"></i> Reset</button></a>
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
                  <th>Branch Name</th>
                  <th>From Time</th>
                  <th>To Time</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

                <?php
                $objects = BranchWorkingTime::find_all();
                foreach ($objects as $data_data) {
                  ?>
                  <tr>
                    <td><?php echo $data_data->branch_id()->name ?></td>
                    <td><?php echo $data_data->start_time ?></td>
                    <td><?php echo $data_data->end_time ?></td>
                    <td>
                      <form action="branch_working_time.php" method="post" style="float: left;">
                        <input type="hidden" name="id" value="<?php echo $data_data->id ?>"/>
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
  var id = <?php echo ($data->id) ? 1 : 0; ?>;

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
