<?php
require_once './../util/initialize.php';
include 'common/upper_content.php';

if (isset($_POST["id"])) {
  $data = StockReceive::find_by_id($_POST["id"]);
} else {
  $data = new StockReceive();
}
?>

<!--page content-->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3 style="font-weight:800;">Warehouse Stock In</h3>
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
            <h2 id="title" style="font-weight:700;"><?php echo (empty($data->id)) ? 'Add' : 'Edit'; ?> Warehouse Stock In</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <form id="formRole" action="proccess/stock_receive_process.php" method="post" class="form-horizontal form-label-left">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <input type="hidden" class="form-control" id="txtId" name="id" value="<?php echo $data->id; ?>" />
                    
                <div class="form-group">
                  <label>Product</label>
                  <input type="text" class="form-control" placeholder="Product code ..." id="stock_code" name="code" value="<?php echo $data->p_code; ?>" onkeyup="checkProductCode(this.value)" required="">
                  <span id="txtHint_code"></span>
                </div>

                <div class="form-group">
                  <label>Barcode</label>
                  <input type="text" class="form-control" placeholder="Barcode ..." id="stock_barcode" name="barcode" value="<?php echo $data->barcode; ?>" onkeyup="checkBarcode(this.value)" required="">
                </div>

                <div class="form-group">
                  <label>Quantity</label>
                  <input type="number" class="form-control" placeholder="" id="stock_quantity" name="quantity" value="<?php echo $data->quantity; ?>" onkeyup="checkQuantity(this.value)" required="">
                </div>

                <div class="form-group">
                  <label>Datetime</label>
                  <input type="datetime-local" class="form-control" id="stock_datetime" name="datetime" value="<?php echo $data->datetime == '' ? '' : date('Y-m-d\TH:i', strtotime($data->datetime)); ?>" required="">
                </div>
                
                <div class="modal-footer col-md-12 col-sm-12 col-xs-12">
                  <?php if(Functions::check_privilege_by_module_action("StockReceive", "ins")) { ?>
                    <div class=" col-md-4 col-sm-4 col-xs-12">
                      <button id="btnSave" type="button" name="save" class="btn btn-block btn-success"><i class="fa fa-floppy-o"></i>&nbsp;Save</button>
                    </div>
                  <?php } ?>
                  <?php if(Functions::check_privilege_by_module_action("StockReceive", "del")){ ?>
                    <div class=" col-md-4 col-sm-4 col-xs-12" style="display: <?php echo (empty($data->id)) ? 'none' : 'initial'; ?>">
                      <button id="btnDelete" type="button" name="delete" class="btn btn-block btn-danger" ><i class="fa fa-trash"></i>&nbsp;Delete</button>
                    </div>
                  <?php } ?>
                  <div class=" col-md-4 col-sm-4 col-xs-12">
                    <a href="stock_receive.php"><button type="button" name="reset" class="btn btn-block btn-primary"><i class="fa fa-history"></i>&nbsp;Reset</button></a>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_content">
            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>S/N</th>
                    <th>Code</th>
                    <th>Barcode</th>
                    <th>Quantity</th>
                    <th>Datetime</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $objects = StockReceive::find_all();
                  $count = 0;
                  foreach ($objects as $data_data) {
                    ++$count;
                    ?>
                    <tr>
                      <td><?php echo $count ?></td>
                      <td><?php echo $data_data->p_code ?></td>
                      <td><?php echo $data_data->barcode ?></td>
                      <td><?php echo $data_data->quantity ?></td>
                      <td><?php echo $data_data->datetime ?></td>
                    <td>
                      <form action="stock_receive.php" method="post" style="float: left;">
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
        </div>
      </div>
    </div>
  </div>
</div>
<!--/page content-->
<?php include 'common/bottom_content.php'; ?>

<script>
function checkBarcode(value) {
  var barcode = value.trim();  
  if(barcode.length > 0) {
    $("#stock_barcode").css({"border": "1px solid #ccc"}); 
  }
}

function checkQuantity(value) {
  var quantity = value.trim();  
  if(quantity.length > 0) {
    $("#stock_quantity").css({"border": "1px solid #ccc"}); 
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
          $("#stock_code").css({"border": "1px solid #ccc"}); 
        } else {
          $("#txtHint_code").html('<b style="color:red;">Code not exist</b>');
          $("#stock_code").css({"border": "1px solid red"});
        }
      },
      error: (error) => {
        console.log(error);
      }
    });
  } else {
    $("#stock_code").css({"border": "1px solid #ccc"}); 
  }
}

// existing check ends
function getFormErrors(){
  var errors = new Array();
  var element;
  var element_value;

  element = $("#stock_code");
  element_value = element.val();
  if (element_value === "") {
    errors.push("Product Code - cannot be empty");
    element.css({"border": "1px solid red"});
  } else  {
    element.css({"border": "1px solid #ccc"});
  }

  element = $("#stock_barcode");
  element_value = element.val();
  if (element_value === "") {
    errors.push("Stock barcode - cannot be empty");
    element.css({"border": "1px solid red"});
  } else  {
    element.css({"border": "1px solid #ccc"});
  }

  element = $("#stock_quantity");
  element_value = element.val();
  if (element_value === "") {
    errors.push("Stock quantity - cannot be empty");
    element.css({"border": "1px solid red"});
  } else  {
    element.css({"border": "1px solid #ccc"});
  }

  element = $("#stock_datetime");
  element_value = element.val();
  if (element_value === "") {
    errors.push("Stock datetime - cannot be empty");
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
  var id = <?php echo ($data->id) ? 1 : 0; ?>;
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
