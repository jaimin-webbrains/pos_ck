<?php
require_once './../util/initialize.php';
include 'common/upper_content.php';

if (!(isset($_POST["id"]) && $role = ColourTube::find_by_id($_POST["id"]))) {
  $role = new ColourTube();
}
?>

<!--page content-->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3 style="font-weight:800;">Colour Tube</h3>
      </div>

      <div class="title_right">

      </div>
    </div>

    <div class="clearfix"></div>

    <?php Functions::output_result(); ?>

    <div class="row">
      <div class="col-md-6 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
            <h2 id="title" style="font-weight:700;"><?php echo (empty($role->id)) ? 'Add' : 'Edit'; ?> Colour Tube</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <form id="formRole" action="proccess/colour_tube_process.php" method="post" class="form-horizontal form-label-left" enctype="multipart/form-data" >
              <div class="col-md-12 col-sm-12 col-xs-12">
                <input type="hidden" class="form-control" id="txtId" name="id" value="<?php echo $role->id; ?>" />

                <div class="form-group">
                  <label>Code</label>                  
                  <input type="text" maxlength="60" class="form-control" placeholder="Code" id="colour_code" name="code" value="<?php echo $role->code; ?>" onkeyup="checkColourCode(this.value)" required="">
                  <span id="txtHint_code"></span>
                </div>

                <div class="form-group">
                  <label>Description</label>
                  <input type="text" class="form-control" placeholder="description" id="colour_description" name="description" value="<?php echo $role->description; ?>" onkeyup="checkColourDescription(this.value)" required="">
 
                </div>

                <div class="form-group">
                  <label>Tube Capacity</label>
                  <input type="number" class="form-control" placeholder="Capacity (%)" id="colour_capacity" name="capacity" value="<?php echo $role->capacity; ?>" onkeyup="checkColourCapacity(this.value)" required="">
                </div>

                <div class="form-group">
                  <label>Unit</label>
                  <input type="text" class="form-control" placeholder="Unit" id="colour_unit" name="unit" value="<?php echo $role->unit; ?>" onkeyup="checkColourUnit(this.value)" required="">
                </div>
              <div class="modal-footer col-md-12 col-sm-12 col-xs-12">
                <?php if(Functions::check_privilege_by_module_action("ColourTube","ins")){ ?>
                  <div class=" col-md-4 col-sm-4 col-xs-12">
                    <button id="btnSave" type="button" name="save" class="btn btn-block btn-success"><i class="fa fa-floppy-o"></i> Save</button>
                  </div>
                <?php } ?>
                <?php if(Functions::check_privilege_by_module_action("ColourTube","del")){ ?>
                  <div class=" col-md-4 col-sm-4 col-xs-12" style="display: <?php echo (empty($role->id)) ? 'none' : 'initial'; ?>">
                    <button id="btnDelete" type="button" name="delete" class="btn btn-block btn-danger" ><i class="fa fa-trash"></i> Delete</button>
                  </div>
                <?php } ?>
                <div class=" col-md-4 col-sm-4 col-xs-12">
                  <a href="colour_tube.php"><button type="button" name="reset" class="btn btn-block btn-primary"><i class="fa fa-history"></i> Reset</button></a>
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
          <a href="service_category.php" target="_blank"><button id="btnNew" type="button" class="btn btn-round btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="glyphicon glyphicon-plus"></i> Add New</button></a>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>S/N</th>
                <th>Code</th>
                <th>Description</th>
                <th>ML Per Tube Capacity</th>
                <th>Unit</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>

            <?php
            $objects = ColourTube::find_all();
            $count = 0;
            foreach ($objects as $role_data) {
                ++$count;
                ?>
                <tr>
                  <td><?php echo $count ?></td>
                  <td><?php echo $role_data->code ?></td>
                  <td><?php echo $role_data->description ?></td>
                  <td><?php echo $role_data->capacity ?></td>
                  <td><?php echo $role_data->unit ?></td>
                <td>
                  <form action="colour_tube.php" method="post" style="float: left;">
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
  </div>


</div>
</div>
</div>
<!--/page content-->
<?php include 'common/bottom_content.php'; ?> bottom content
<script>
function checkColourDescription(value) {
  var colour_description = value.trim();  
  if(colour_description.length > 0) {
    $("#colour_description").css({"border": "1px solid #ccc"}); 
  }
}
function checkColourCapacity(value) {
  var colour_capacity = value.trim();  
  if(colour_capacity.length > 0) {
    $("#colour_capacity").css({"border": "1px solid #ccc"}); 
  }
}
function checkColourUnit(value) {
  var colour_unit = value.trim();  
  if(colour_unit.length > 0) {
    $("#colour_unit").css({"border": "1px solid #ccc"}); 
  }
}

function checkColourCode(code) {
  var colour_code = code.trim();  
  if(colour_code.length > 0) {
    $.ajax({
      type: 'post',
      url: 'proccess/data_check.php',
      data: {
        'check_colour_code': colour_code
      },
      success: (response)  => {
        var jsonData = JSON.parse(response);
        if(jsonData.success === true) {          
          $("#txtHint_code").html('<b style="color:green;">You can use the code</b>');
          $("#colour_code").css({"border": "1px solid #ccc"}); 
        } else {
          $("#txtHint_code").html('<b style="color:red;">Code present</b>');
          $("#colour_code").css({"border": "1px solid red"});
        }
      },
      error: (error) => {
        console.log(error);
      }
    });
  } else {
    $("#colour_code").css({"border": "1px solid #ccc"}); 
  }
}

function getErrors(){
  var errors = new Array();
  var element;
  var element_value;

  element = $("#colour_code");
  element_value = element.val();
  if (element_value === "") {
    errors.push("Colour Code - cannot be empty");
    element.css({"border": "1px solid red"});
  } else  {
    element.css({"border": "1px solid #ccc"});
  }

  element = $("#colour_description");
  element_value = element.val();
  if (element_value === "") {
    errors.push("Colour Description - cannot be empty");
    element.css({"border": "1px solid red"});
  } else  {
    element.css({"border": "1px solid #ccc"});
  }

  element = $("#colour_capacity");
  element_value = element.val();
  if (element_value === "") {
    errors.push("Colour Capacity - cannot be empty");
    element.css({"border": "1px solid red"});
  } else  {
    element.css({"border": "1px solid #ccc"});
  }

  element = $("#colour_unit");
  element_value = element.val();
  if (element_value === "") {
    errors.push("Colour Unit - cannot be empty");
    element.css({"border": "1px solid red"});
  } else  {
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
    if (UserPrivileges.checkPrivilege("proccess/privileges_authenticate.php", "Colour", "upd")) {
      FormOperations.confirmSave(validateForm(), "#formRole", id, null);
    }
  } else {
    if (UserPrivileges.checkPrivilege("proccess/privileges_authenticate.php", "Colour", "ins")) {
      FormOperations.confirmSave(validateForm(), "#formRole", id, null);
    }
  }
});

$("#btnDelete").click(function () {

  if (UserPrivileges.checkPrivilege("proccess/privileges_authenticate.php", "Colour", "del")) {
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
