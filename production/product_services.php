<?php
require_once './../util/initialize.php';
include 'common/upper_content.php';


if (!(isset($_POST["id"]) && $role = ProductUsageServices::find_by_id($_POST["id"]))) {
  $role = new ProductUsageServices();
}
?>

<!--page content-->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3 style="font-weight:800;">Product Service Sales Code</h3>
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
            <h2 id="title" style="font-weight:700;"><?php echo (empty($role->id)) ? 'Add' : 'Edit'; ?> Product Service</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <form id="formRole" action="proccess/product_services_process.php" method="post" class="form-horizontal form-label-left" enctype="multipart/form-data" >
              <div class="col-md-12 col-sm-12 col-xs-12">
                <input type="hidden" class="form-control" id="txtId" name="id" value="<?php echo $role->id; ?>" />
                <div class="form-group">
                  <label>Service Code</label>
                  <input type="text" maxlength="60" class="form-control" placeholder="Service Code..." id="service_code" name="code" value="<?php echo $role->p_code; ?>" onkeyup="checkServiceCode(this.value)" required="">
                  <span id="txtHint_code"></span>
                </div>
                <div class="form-group">
                  <label for="exampleFormControlInput2">Select Product Use Code</label>
                  <select id="service_use_code" style="display: none" multiple="multiple" name="p_u_code[]">
                    <?php
                      $objects = ProductUnit::find_all();
                      if(empty($role->p_use_code)){
                        foreach ($objects as $role_data){
                          echo '<option value="'.$role_data->p_code.'">'.$role_data->p_code.'</option>';
                        }
                      }
                      else{
                        foreach ($objects as $role_data){
                          $objectsC = ProductUsageServices::find_by_use_id($_POST["id"]);
                          foreach ($objectsC as $make_data);
                            $x = (explode(",",$make_data->p_use_code));
                            for($i=0;$i<count($x);$i++){
                              if($role_data->p_code == $x[$i])
                              {
                                echo '<option selected value="'.$x[$i].'">'.$x[$i].'</option>';
                              }
                            }
                        }
                      }
                    ?>
                  </select>
                </div>

                <div class="form-group">
                  <label>Volume</label>
                  <input type="text" class="form-control" placeholder="volume" id="service_volume" name="volume" value="<?php echo $role->volume; ?>" onkeyup="checkServiceVolume(this.value)" required="">
                  <span id="txtHint"></span>
                </div>

                <div class="modal-footer col-md-12 col-sm-12 col-xs-12">
                <?php if(Functions::check_privilege_by_module_action("ProductUnit","ins")){ ?>

                  <div class=" col-md-4 col-sm-4 col-xs-12">
                    <button id="btnSave" type="button" name="save" class="btn btn-block btn-success"><i class="fa fa-floppy-o"></i> Save</button>
                  </div>
                <?php } ?>
                <?php if(Functions::check_privilege_by_module_action("ProductUnit","del")){ ?>
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
        <div class="x_content">
          <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>S/N</th>
                <th>Service Code</th>
                <th>Usage Code</th>
                <th>Volume</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $objects = ProductUsageServices::find_all();
              $count = 0;
              foreach ($objects as $role_data) {
                ++$count;
                ?>
                <tr>
                  <td><?php echo $count ?></td>
                  <td><?php echo $role_data->p_code ?></td>
                  <td><?php echo $role_data->p_use_code;?></td>
                  <td><?php echo $role_data->volume ?></td>
                  <td>
                    <form action="product_services.php" method="post" style="float: left;">
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
<?php include 'common/bottom_content.php'; ?>
<script>

function checkServiceVolume(volume) {
  var service_volume = volume.trim();  
  if(service_volume.length > 0) {
    $("#service_volume").css({"border": "1px solid #ccc"}); 
  }
}

function checkServiceCode(code) {
  var service_code = code.trim();  
  if(service_code.length > 0) {
    $.ajax({
      type: 'post',
      url: 'proccess/data_check.php',
      data: {
        'check_service_code': service_code
      },
      success: (response)  => {
        var jsonData = JSON.parse(response);
        if(jsonData.success === true) {          
          $("#txtHint_code").html('<b style="color:green;">Code present</b>');
          $("#service_code").css({"border": "1px solid #ccc"}); 
        } else {
          $("#txtHint_code").html('<b style="color:red;">You cannot use the code</b>');
          $("#service_code").css({"border": "1px solid red"});
        }
      },
      error: (error) => {
        console.log(error);
      }
    });
  } else {
    $("#service_code").css({"border": "1px solid #ccc"}); 
  }
}

// existing check ends
function getFormErrors(){
  var errors = new Array();
  var element;
  var element_value;

  element = $("#service_code");
  element_value = element.val();
  if (element_value === "") {
    errors.push("Service Code - cannot be empty");
    element.css({"border": "1px solid red"});
  } else  {
    element.css({"border": "1px solid #ccc"});
  }

  element = $("#service_volume");
  element_value = element.val();
  if (element_value === "") {
    errors.push("Service Volume - cannot be empty");
    element.css({"border": "1px solid red"});
  } else  {
    element.css({"border": "1px solid #ccc"});
  }

  element = $("#service_use_code");
  element_value = $('#service_use_code option:selected').length;
  if (element_value === 0) {
    errors.push("Service Use Code - cannot be empty");
    element.css({"border": "1px solid red"});
  } else  {
    element.css({"border": "1px solid #ccc"});
  }

  return errors;
}

function validateForm() {
  var errors = getFormErrors();
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

</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.16/js/bootstrap-multiselect.js" ></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#service_use_code').multiselect();
});
</script>
