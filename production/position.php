<?php
require_once './../util/initialize.php';
include 'common/upper_content.php';

if (!(isset($_POST["id"]) && $role = Position::find_by_id($_POST["id"]))) {
  $role = new Position();
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
        <h3 style="font-weight:800;">Position</h3>
      </div>

      <div class="title_right">

      </div>
    </div>

    <div class="clearfix"></div>

    <?php Functions::output_result(); ?>

    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2 id="title" style="font-weight:700;">Position</h2>
          <div style="float:right">
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#AddPositionModal"><i class="fa fa-plus" aria-hidden="true"></i> Add Position</button>
          </div>
          
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>S/N</th>
                <th>Position</th>
                <th>Category</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>

              <?php
              $objects = Position::find_all();
              $count = 0;
              foreach ($objects as $role_data) {
                ++$count;
                ?>
                <tr>
                  <td><?php echo $count ?></td>
                  <td><?php echo $role_data->name ?></td>
                  <td><?php echo $role_data->category()->name ?></td>
                  <td>
                    <a class="btn mb-2 mr-2 btn-outline-primary"  href="javascript:void(0);" data-toggle="modal" data-target="#UpdatePositionModal<?php echo $role_data->id; ?>" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>


                    <!-- <button id="btnDelete" type="button" name="delete" title="Delete" class="btn mb-2 mr-2 btn-outline-danger" ><i class="fa fa-trash"></i></button> -->

                    <!-- <a class="btn btn-outline btn-danger" href="proccess/position_process.php?id=<?php echo $role_data->id; ?>" title="Delete"><i class="fa fa-times"></i></a> -->


                   <form class="table_from" action="proccess/position_process.php" method="POST">
                    <input type="hidden" class="form-control" id="txtId" name="id" value="<?php echo $role_data->id; ?>"/>
                      <button type="submit" name="delete" class="btn btn-danger" onClick="return confirm(\'Do you realy want to delete this?\')" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-times"></i></button>
                  </form>


                  </td>
                  </td>
                  
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

    <!-- add model -->
    <div class="modal fade" id="AddPositionModal" tabindex="-1" role="dialog" aria-labelledby="AddPositionModalLabel"   aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="AddPositionModalLabel">Add Position</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form id="formRole" action="proccess/position_process.php" method="post" class="form-horizontal form-label-left" enctype="multipart/form-data">
            <div class="modal-body">
                <div class="form-group">
                  <label for="name" class="col-form-label">Position:
                    <small style="color:red;">* Maximum number of Characters: 60 </small>
                  </label>
                  <input type="text" class="form-control" name="name" id="name" maxlength="60" placeholder="Enter Name">
                </div>
                <div class="form-group">
                  <label for="category" class="col-form-label">Category:
                    <small style="color:red;">*</small>
                  </label>
                  <select class="form-control" name="category" id="category">
                  <option value="">Select</option>
                      <?php
                      foreach (ServiceCategory::find_all() as $status_data ) {
                        echo "<option value='".$status_data->id."'>".$status_data->name."</option>";
                      }
                      ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="ranking" class="col-form-label">Ranking:
                  </label>
                  <input type="text" class="form-control" name="ranking" id="ranking" placeholder="Enter A1">
                </div>
            
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              
              <button id="btnSave" type="button" name="save" class="btn btn-success"><i class="fa fa-floppy-o"></i> Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    
    <!-- update model -->
    <?php
      $objects = Position::find_all();
      foreach ($objects as $role_data) {
      ?>
        <div class="modal fade" id="UpdatePositionModal<?php echo $role_data->id; ?>" tabindex="-1" role="dialog" aria-labelledby="UpdatePositionModalLabel"   aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="UpdatePositionModalLabel">Edit Position</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form id="formRoleUpdate" action="proccess/position_process.php" method="post" class="form-horizontal form-label-left" enctype="multipart/form-data">
              <input type="hidden" class="form-control" id="txtId" name="id" value="<?php echo $role_data->id; ?>" />
                <div class="modal-body">
                    <div class="form-group">
                      <label for="name" class="col-form-label">Position:
                        <small style="color:red;">* Maximum number of Characters: 60 </small>
                      </label>
                      <input type="text" class="form-control" name="name" id="name" maxlength="60" value="<?php echo $role_data->name; ?>">
                    </div>
                    <div class="form-group">
                      <label for="category" class="col-form-label">Category:
                        <small style="color:red;">*</small>
                      </label>
                      <select class="form-control" name="category" id="category">
                      <?php
                      foreach (ServiceCategory::find_all() as $status_data ) {
                        ?>
                        <option value='<?php echo $status_data->id; ?>' <?php if($status_data->id == $role_data->category) echo "selected"?>><?php echo $status_data->name; ?></option>
                      <?php
                      }
                      ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="ranking" class="col-form-label">Ranking:
                      </label>
                      <input type="text" class="form-control" name="ranking" id="ranking" value="<?php echo $role_data->ranking; ?>">
                    </div>
                
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button id="btnUpdate" type="button" name="update" class="btn btn-success"><i class="fa fa-floppy-o"></i> Save Changes</button>
                </div>
              </form>
            </div>
          </div>
        </div>
    <?php
      }
    ?>
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

  element=$("#name");
  element_value=element.val();
  if ( element_value === "") {
    errors.push("Name - Invalid");
    element.css({"border": "1px solid red"});
  }else{
    element.css({"border": "1px solid #ccc"});
  }

  element=$("#category");
  element_value=element.val();
  if ( element_value === "") {
    errors.push("Category - Invalid");
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

  if(id) {
    if (UserPrivileges.checkPrivilege("proccess/privileges_authenticate.php", "Service", "upd")) {
      FormOperations.confirmSave(validateForm(), "#formRole", id, null);
    }
  } else {
    if (UserPrivileges.checkPrivilege("proccess/privileges_authenticate.php", "Service", "ins")) {
      FormOperations.confirmSave(validateForm(), "#formRole", id, null);
    }
  }
});

// $("#btnUpdate").click(function () {
//   var id = <?php echo ($role->id) ? 1 : 1; ?>;
//     if (UserPrivileges.checkPrivilege("proccess/privileges_authenticate.php", "Position", "upd")) {
//       FormOperations.confirmSave(validateForm(), "#formRoleUpdate", id, null);
//     }
  
// });

$("#btnDelete").click(function () {
  if (UserPrivileges.checkPrivilege("proccess/privileges_authenticate.php", "Service", "del")) {
    FormOperations.confirmDelete("#formRoleUpdate");
  }
});
</script>
