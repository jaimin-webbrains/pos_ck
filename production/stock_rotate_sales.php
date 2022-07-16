<?php
require_once './../util/initialize.php';
include 'common/upper_content.php';

if (isset($_POST["id"])) {
  $stock_rotate_sales = StockRotateSales::find_by_id($_POST["id"]);
} else {
  $stock_rotate_sales = new StockRotateSales();
}
?>

<!--page content-->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3 style="font-weight:800;">Stock Rotate Sales</h3>
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
            <h2 id="title" style="font-weight:700;"><?php echo (empty($stock_rotate_sales->id)) ? 'Add' : 'Edit'; ?> Stock Rotate Sales</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <form id="formRole" action="proccess/stock_rotate_sales_process.php" method="post" class="form-horizontal form-label-left">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <input type="hidden" class="form-control" id="txtId" name="id" value="<?php echo $stock_rotate_sales->id; ?>" />

                <div class="form-group">
                  <label>Branch</label><br/>
                  <select class="form-control" name="branch" id="stock_branch">
                    <?php				  
                      foreach (Branch::find_all() as $branch) {
                        if($stock_rotate_sales->branch_id == $branch->id)
                          echo "<option selected value='".$branch->id."'>".$branch->name."</option>";
                        else
                          echo "<option value='".$branch->id."'>".$branch->name."</option>";
                      }		  
                    ?>
                  </select>
                </div>
                    
                <div class="form-group">
                  <label>Product</label>
                  <input type="text" class="form-control" placeholder="Product code ..." id="stock_code" name="code" value="<?php echo $stock_rotate_sales->p_code; ?>" onkeyup="checkProductCode(this.value)" required="">
                  <span id="txtHint_code"></span>
                </div>                

                <div class="form-group">
                  <label>Reasons</label>
                  <input type="text" class="form-control" placeholder="Reasons ..." id="stock_reasons" name="reasons" value="<?php echo $stock_rotate_sales->reasons; ?>" onkeyup="checkReasons(this.value)" required="">
                </div>

                <div class="form-group">
                  <label>Datetime</label>
                  <input type="datetime-local" class="form-control" id="stock_datetime" name="datetime" value="<?php echo $stock_rotate_sales->datetime == '' ? '' : date('Y-m-d\TH:i', strtotime($stock_rotate_sales->datetime)); ?>" required="">
                </div>

                <div class="form-group">
                  <label>Quantity</label>
                  <input type="number" class="form-control" placeholder="quantity ..." id="stock_quantity" name="quantity" value="<?php echo @$stock_rotate_sales->quantity; ?>"  required="">
                </div>
                
                <div class="modal-footer col-md-12 col-sm-12 col-xs-12">
                  <?php if(Functions::check_privilege_by_module_action("StockRotateSales", "ins")) { ?>
                    <div class=" col-md-4 col-sm-4 col-xs-12">
                      <button id="btnSave" type="button" name="save" class="btn btn-block btn-success"><i class="fa fa-floppy-o"></i>&nbsp;Save</button>
                    </div>
                  <?php } ?>
                  <?php if(Functions::check_privilege_by_module_action("StockRotateSales", "del")){ ?>
                    <div class=" col-md-4 col-sm-4 col-xs-12" style="display: <?php echo (empty($stock_rotate_sales->id)) ? 'none' : 'initial'; ?>">
                      <button id="btnDelete" type="button" name="delete" class="btn btn-block btn-danger" ><i class="fa fa-trash"></i>&nbsp;Delete</button>
                    </div>
                  <?php } ?>
                  <div class=" col-md-4 col-sm-4 col-xs-12">
                    <a href="stock_rotate_sales.php"><button type="button" name="reset" class="btn btn-block btn-primary"><i class="fa fa-history"></i>&nbsp;Reset</button></a>
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
                    <th>Branch</th>
                    <th>Code</th>
                    <th>Reasons</th>
                    <th>Datetime</th>
                    <th>Quantity</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $objects = StockRotateSales::find_all();
                  $count = 0;
                  foreach ($objects as $obj) {
                    ++$count;
                    ?>
                    <tr>
                      <td><?php echo $count ?></td>
                      <td><?php $branch = Branch::find_by_id($obj->branch_id); echo $branch->name ?></td>
                      <td><?php echo $obj->p_code ?></td>
                      <td><?php echo $obj->reasons ?></td>
                      <td><?php echo $obj->datetime ?></td>
                      <td><?php echo $obj->quantity ?></td>
                    <td>
                      <form action="stock_rotate_sales.php" method="post" style="float: left;">
                        <input type="hidden" name="id" value="<?php echo $obj->id ?>"/>
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
function checkReasons(value) {
  var reasons = value.trim();  
  if(reasons.length > 0) {
    $("#stock_reasons").css({"border": "1px solid #ccc"}); 
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
          $("#txtHint_code").html('<b style="color:red;">You cannot use the code</b>');
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

  element = $("#stock_reasons");
  element_value = element.val();
  if (element_value === "") {
    errors.push("Stock WriteOff Reasons - cannot be empty");
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
  var id = <?php echo ($stock_rotate_sales->id) ? 1 : 0; ?>;
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
