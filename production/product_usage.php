<?php
require_once './../util/initialize.php';
include 'common/upper_content.php';

if (!(isset($_POST["id"]) && $role = ProductUsageSales::find_by_id($_POST["id"]))) {
  $role = new ProductUsageSales();
}
?>

<!--page content-->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3 style="font-weight:800;">Product Sales Only</h3>
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
            <h2 id="title" style="font-weight:700;"><?php echo (empty($role->id)) ? 'Add' : 'Edit'; ?> Product Usage</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <form id="formRole" action="proccess/product_usage_process.php" method="post" class="form-horizontal form-label-left" enctype="multipart/form-data" >
              <div class="col-md-12 col-sm-12 col-xs-12">
                <input type="hidden" class="form-control" id="txtId" name="id" value="<?php echo $role->id; ?>" />
                <div class="form-group">
                  <label>Product Sales Code</label>
                  <input type="text" class="form-control" placeholder="Product code ..." id="product_code" name="code" value="<?php echo $role->p_code; ?>" onkeyup="checkProductCode(this.value)" required="">
                  <span id="txtHint_code"></span>
                </div>
                <div class="form-group">
                  <label>Volume</label>
                  <input type="number" class="form-control" placeholder="volume" id="product_volume" name="volume" value="<?php echo $role->p_volume; ?>" onkeyup="checkProductVolume(this.value)" required="">
                </div>
                <div class="form-group">
                  <label>Unit</label>
                  <input type="text" class="form-control" placeholder="unit type (ML, G, L)" id="product_unit" name="unit" value="<?php echo $role->p_unit; ?>" onkeyup="checkProductUnit(this.value)" required="">
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
                <th>Sales Code</th>
                <th>Usage Code </th>
                <th>Volume</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $objects = ProductUsageSales::find_all();
              $count = 0;
              foreach ($objects as $role_data) {
                ++$count;
              ?>
                <tr>
                  <td><?php echo $count ?></td>
                  <td><?php echo $role_data->p_code ?></td>
                  <td><?php echo $role_data->p_use_code;?></td>
                  <td><?php echo $role_data->p_volume ?></td>
                  <td>
                    <form action="product_usage.php" method="post" style="float: left;">
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
function checkProductVolume(volume) {
  var product_volume = volume.trim();  
  if(product_volume.length > 0) {
    $("#product_volume").css({"border": "1px solid #ccc"}); 
  }
}

function checkProductUnit(unit) {
  var product_unit = unit.trim();  
  if(product_unit.length > 0) {
    $("#product_unit").css({"border": "1px solid #ccc"}); 
  }
}

function checkProductCode(code) {
  var product_code = code.trim();  
  if(product_code.length > 0) {
    $.ajax({
      type: 'post',
      url: 'proccess/data_check.php',
      data: {
        'product_code': product_code
      },
      success: (response)  => {
        var jsonData = JSON.parse(response);
        if(jsonData.success === true) {          
          $("#txtHint_code").html('<b style="color:green;">Code present</b>');
          $("#product_code").css({"border": "1px solid #ccc"}); 
        } else {
          $("#txtHint_code").html('<b style="color:red;">You cannot use the code</b>');
          $("#product_code").css({"border": "1px solid red"});
        }
      },
      error: (error) => {
        console.log(error);
      }
    });
  } else {
    $("#product_code").css({"border": "1px solid #ccc"}); 
  }
}

// existing check ends
function getFormErrors(){
  var errors = new Array();
  var element;
  var element_value;

  element = $("#product_code");
  element_value = element.val();
  if (element_value === "") {
    errors.push("Product Code - cannot be empty");
    element.css({"border": "1px solid red"});
  } else  {
    element.css({"border": "1px solid #ccc"});
  }

  element = $("#product_volume");
  element_value = element.val();
  if (element_value === "") {
    errors.push("Product Volume - cannot be empty");
    element.css({"border": "1px solid red"});
  } else  {
    element.css({"border": "1px solid #ccc"});
  }

  element = $("#product_unit");
  element_value = element.val();
  if (element_value === "") {
    errors.push("Product Unit - cannot be empty");
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