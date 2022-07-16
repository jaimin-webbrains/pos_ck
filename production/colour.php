<?php
require_once './../util/initialize.php';
include 'common/upper_content.php';

if (!(isset($_POST["id"]) && $role = Colour::find_by_id($_POST["id"]))) {
  $role = new Colour();
}
?>

<!--page content-->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
        
      <div class="title_left">
        <h3 style="font-weight:800;">Colour</h3>
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
            <h2 id="title" style="font-weight:700;"><?php echo (empty($role->id)) ? 'Add' : 'Edit'; ?> Colour Sales</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <form id="formRole" action="proccess/colour_process.php" method="post" class="form-horizontal form-label-left" enctype="multipart/form-data" >
              <div class="col-md-12 col-sm-12 col-xs-12">
                <input type="hidden" class="form-control" id="txtId" name="id" value="<?php echo $role->id; ?>" />

                <div class="form-group">
                  <label>Code</label>                  
                  <input type="text" maxlength="60" class="form-control" placeholder="Colour Code" id="colour_code" name="code" value="<?php echo $role->code; ?>" onkeyup="checkColourCode(this.value)" required="">
                  <span id="txtHint_code"></span>
                </div>

                <div class="form-group">
                  <label>Description</label>
                  <input type="text" class="form-control" placeholder="description" id="colour_description" name="description" value="<?php echo $role->description; ?>" onkeyup="checkColourDescription(this.value)" required="">
                  <span id="txtHint"></span>
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
                    <label> Colour Image</label>
                    <input id="inpFile" type="file" name="files_to_upload" />
                  </div>
                </div>

              <div class="form-group">
                <label>Branch</label>
                <br>
                <label><input type="checkbox" id="select-all" name="all_b"> All</label>
                <br/>

                <?php

                foreach (Branch::find_all() as $branch_data) {

                 $check = ColourBranch::find_by_colour_branch($branch_data->id,$role->id);
                  if(count($check) > 0){
                     ?>

                  <label><input type="checkbox" class="checkbox_branch" name="<?php echo $branch_data->id; ?>"checked> <?php echo $branch_data->name; ?></label>
                  <?php
                  }
                  else{
                     ?>
                  <label><input type="checkbox" class="checkbox_branch" name="<?php echo $branch_data->id; ?>"> <?php echo $branch_data->name; ?></label>
                  <?php
                  }


                }
                ?>

              </div>

              <div class="modal-footer col-md-12 col-sm-12 col-xs-12">
                <?php if(Functions::check_privilege_by_module_action("Colour","ins")){ ?>

                  <div class=" col-md-4 col-sm-4 col-xs-12">
                    <button id="btnSave" type="button" name="save" class="btn btn-block btn-success"><i class="fa fa-floppy-o"></i> Save</button>
                  </div>
                <?php } ?>
                <?php if(Functions::check_privilege_by_module_action("Colour","del")){ ?>
                  <div class=" col-md-4 col-sm-4 col-xs-12" style="display: <?php echo (empty($role->id)) ? 'none' : 'initial'; ?>">
                    <button id="btnDelete" type="button" name="delete" class="btn btn-block btn-danger" ><i class="fa fa-trash"></i> Delete</button>
                  </div>
                <?php } ?>
                <div class=" col-md-4 col-sm-4 col-xs-12">
                  <a href="colour.php"><button type="button" name="reset" class="btn btn-block btn-primary"><i class="fa fa-history"></i> Reset</button></a>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!------------------------------------------------------------------------------------------------------------------------------->


    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <a href="service_category.php" target="_blank"><button id="btnNew" type="button" class="btn btn-round btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="glyphicon glyphicon-plus"></i> Add New</button></a>
          <a href="colour_tube.php"><button id="btnNew" type="button" class="btn btn-round btn-success" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="glyphicon glyphicon-plus"></i> Add Colour Tube</button></a>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>S/N</th>
                <th>Code</th>
                <th>Description</th>
                
                <th>Image</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>

              <?php

              // $total_records = Product::row_count();
              // $pagination = new Pagination($total_records);
              // $objects = Product::find_all_by_limit_offset($pagination->records_per_page, $pagination->offset());
              $objects = Colour::find_all();
              $count = 0;
              foreach ($objects as $role_data) {
                ++$count;
                ?>
                <tr>
                  <td><?php echo $count ?></td>
                  <td><?php echo $role_data->code ?></td>
                  <td><?php echo $role_data->description ?></td>
                  

                  <td><?php  $image = "images/user.png";
                  if ($role_data->image != NULL) {
                    $image = "uploads/users/" . $role_data->image;
                  } ?> <img id="imgImage" src="<?php echo $image; ?>" alt=":( image not found..!" class="image img-responsive img-thumbnail" style="width: 60px">
                </td>              

                <td>
                  <form action="colour.php" method="post" style="float: left;">
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

function checkColourDescription(description) {
  var colour_description = description.trim();  
  if(colour_description.length > 0) {
    $("#colour_description").css({"border": "1px solid #ccc"}); 
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
          $("#txtHint_code").html('<b style="color:green;">Code present</b>');
          $("#colour_code").css({"border": "1px solid #ccc"}); 
        } else {
          $("#txtHint_code").html('<b style="color:red;">You cannot use the code</b>');
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
