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
        <h3 style="font-weight:800;">Sales Use Report</h3>
      </div>

      <div class="title_right">

      </div>
    </div>

    <div class="clearfix"></div>

    <?php Functions::output_result(); ?>

    <div class="row">
      <div class="col-md-12 col-sm-6 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2 id="title" style="font-weight:700;">
                <select style="float: right;" name="year" onchange="location = this.options[this.selectedIndex].value;" class="custome-select">
                    <option selected disabled>Select Year</option>
                    <script>
                        var myDate = new Date();
                        var year = myDate.getFullYear();
                          for(var i = 2021; i < year+1; i++){
                          document.write('<option value="?year='+i+'">'+i+'</option>');
                        }
                    </script>
                </select>
                
            </h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <?php if(!empty($_GET['year']))
                { echo '<h3>Report for the Year '.$_GET['year'].' </h3>' ?>
                    <table  id="datatable-responsive" class="table table-striped table-bordered nowrap">
                        <thead class="bg-light text-capitalize">
                            <tr>
                                <th> SN </th>
                                <th> Sales Code </th>
                                <?php 
                                    $month = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"); 
                                    for($i=0; $i<12; $i++) {
                                        print '<th colspan="2" style="text-align: center;">'.$month[$i].'</th>';
                                    }
                                ?>
                                <th colspan="2" style="text-align: center;"> Total </th>
                            </tr>
                            <tr><th colspan="2" style="text-align: center">F <i class="fa fa-arrow-right"></i> frequent <BR> U <i class="fa fa-arrow-right"></i> Usage</th>
                                  <?php for($i=0; $i<12; $i++) { print '<th>F</th><th>U</th>'; } ?>
                                <th>F</th><th>U</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $objects = Product::find_all();
                            $count = 0;
                            foreach ($objects as $role_data) {
                                ++$count; ?>
                                <tr><td><?php echo $count ?></td>
                                    <td><?php echo $role_data->code ?></td>
                                    
                                    <?php
                                        for($i=0; $i<12; $i++) {  $mon = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"); 
                                          $checkObjects = ProductUsageSales::find_by_code_month_and_year($role_data->code,$mon[$i],$_GET['year']);
                                          if(count($checkObjects) == 0){ $c = '-'; }
                                          if(count($checkObjects) > 0){ $c = count($checkObjects); }
                                          
                                          echo '<td>'.$c.'</td><td>';
                                          $sum = array(); $sum1 = array(); $sum2 = array(); $sum3 = array(); $sum4 = array();
                                          foreach($checkObjects as $row){
                                            //echo $row->p_use_code.'<BR>';
                                            $convert = $row->volume;
                                            $break = array("ml","ML","G","g");
                                            $coverted_arr = str_replace($break, "", $convert);
                                            $a = (explode(",", $row->p_use_code));
                                            $b = (explode(",", $row->volume));
                                            $cb =(explode(",", $coverted_arr));
                                            /***********DO WHILE LOOP IS GOOD**************** */
                                            $x = 0; 
                                            
                                            do {
                                              switch($x){
                                                case 0:
                                                    $sum[] = $cb[$x];
                                                  break;
                                                case 1:
                                                    $sum1[] = $cb[$x];
                                                  break;
                                                case 2:
                                                    $sum2[] = $cb[$x];
                                                  break;
                                                case 3:
                                                    $sum3[] = $cb[$x];
                                                  break;
                                                case 4:
                                                    $sum4[] = $cb[$x];
                                                  break;
                                                default:
                                              }
                                              $x++;
                                            } while ($x < count($a));
                                            
                                            /***********DO WHILE LOOP IS GOOD**************** */
                                          }
                                          if(array_sum($sum) == 0)  {}   else { echo array_sum($sum).', '; }
                                          if(array_sum($sum1) == 0) {}  else { echo array_sum($sum1).', '; }
                                          if(array_sum($sum2) == 0) {}  else { echo array_sum($sum2).', '; }
                                          if(array_sum($sum3) == 0) {}  else { echo array_sum($sum3).', '; }
                                          if(array_sum($sum4) == 0) {}  else { echo array_sum($sum4); }
                                         
                                          //$checkUsage = ProductUsageServices::get_usage_amount($role_data->code,$mon[$i],$_GET['year']);
                                          echo '</td>';
                                          
                                        }
                                        $checkCodeYear = ProductUsageSales::find_code_and_year($role_data->code,$_GET['year']);
                                          if(count($checkCodeYear) == 0){ $ca = '-'; }
                                          if(count($checkCodeYear) > 0){ $ca = count($checkCodeYear); }

                                          echo '<td>'.$ca.'</td><td>';

                                          foreach($checkCodeYear as $row_vol){
                                            print $row_vol->volume.'<BR>';
                                          }

                                          /**
                                           * calculate the entire usage
                                           */
                                          

                                          echo '</td>';
                                    ?>
                                    
                                </tr>
                                <?php  
                            }
                            ?>
                            
                        </tbody>
                    </table>


                    <?php 
                }
                ?>
        </div>
      </div>
    </div>
    <!------------------------------------------------------------------------------------------------------------------------------->
    

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
    xmlhttp.open("GET", "proccess/data_check.php?check_product_code=" + str, true);
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.16/js/bootstrap-multiselect.js" ></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#example-getting-started').multiselect();
    });
</script>
