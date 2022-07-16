<?php
require_once './../util/initialize.php';
$con=mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);

//cklim check what is post from branch_employee.php to branch_employee_print.php ...always post "1" even select "all"
//echo '<pre> POST raport ';
//print_r($_POST);  
// echo '</pre>';



?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Branch & Employee Report</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script type="text/javascript">
  function exportTableToExcel(tableID, filename = ''){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');

    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';

    // Create download link element
    downloadLink = document.createElement("a");

    document.body.appendChild(downloadLink);

    if(navigator.msSaveOrOpenBlob){
      var blob = new Blob(['\ufeff', tableHTML], {
        type: dataType
      });
      navigator.msSaveOrOpenBlob( blob, filename);
    }else{
      // Create a link to the file
      downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

      // Setting the file name
      downloadLink.download = filename;

      //triggering the function
      downloadLink.click();
    }
  }
  </script>
</head>
<body>

  <div class="container-fluid">
    <hr/>
    <button class="btn btn-primary" onclick="exportTableToExcel('tblData')">Export Table Data To Excel File</button>

    <?php
    if(isset($_POST['from_date']) && isset($_POST['to_date'])){
     // GET THE POST DATA
      $branch_id = $_POST['branch'];
      $service_user = $_POST['service_user'];
     

      $from_date = $_POST['from_date'];
      $to_date = $_POST['to_date'];
      $service_boolean=false;
 
 //cklim check what is post from branch_employee.php to branch_employee_print.php ...always post "1" even select "all"
   //      if ($service_user =1){$service_user="all";}
  //    echo $service_user;
  //   echo $branch_id;
  //   echo $from_date;
  //   echo $to_date;


      // GET THE TABLE DATA
      $branch_obj = Branch::find_by_id($branch_id);
 //exit();
      // $service_obj = User::find_by_id($service_user);
      ?>
      <div class="row" style="padding-top:30px;">

        <!-- table starts -->
        <?php
        $cat_object = ServiceCategory::find_all();
        $pro_object = ProductCategory::find_all();
        $category_count = count($cat_object) + count($pro_object);
        ?>

        <table id="tblData" class="table table-bordered" style="font-size:10px;width:100%;">
          <thead>
            <tr>
              <th rowspan="2">Branch <br/> Name:</th>
              <th rowspan="2"><?php echo $branch_obj->name; ?></th>
              <th rowspan="2">Code: <br/> <?php echo $branch_obj->code; ?></th>
              <th colspan="<?php echo ($category_count*3)+3; ?>" style="text-align:center;">Category</th>
            </tr>
            <tr>
              <?php
              foreach ($cat_object as $cat_data) {
                echo "<th colspan='3'>".$cat_data->name."</th>";
              }
              foreach ($pro_object as $pro_data) {
                echo "<th colspan='3'>".$pro_data->name."</th>";
              }
              echo "<th style='text-align:center;'>Total head Count</th>";
              echo "<th style='text-align:center;'>Total Sales</th>";

              echo "<th style='text-align:center;'>Total Voucher Value</th>";
              echo "<th style='text-align:center;'>Monthly Commision</th>";

              ?>
            </tr>

            <tr>
              <th>S/no</th>
              <th>Emp No</th>
              <th>Emp Name</th>
              <?php
              foreach ($cat_object as $cat_data) {
                echo "<th style='text-align:center;'>S</th>";
                echo "<th style='text-align:center;'>P</th>";
                echo "<th style='text-align:center;'>R</th>";
              }
              foreach ($pro_object as $pro_data) {
                echo "<th colspan='3' style='text-align:center;'></th>";

              }
              echo "<th style='text-align:center;'></th>";
              echo "<th style='text-align:center;'></th>";
              echo "<th style='text-align:center;'></th>";

              ?>

            </tr>
          </thead>
          <tbody>
       
            <?php
          // cklim check what is post from branch_employee.php to branch_employee_print.php ...always post "1" even select "all"
          // if($service_user == "all"){
    
          $user_count = 0;
            if(($_POST['service_user'] == "all") or ($_POST['service_user'] == 1)) {
              $branch = $_POST['branch'];
              $user_object = User::find_all_service_branch($branch);
              $cog = Branch::find_by_id($branch)->cog;
              $cog_dis = 100 - $cog;
              $cog_dis = $cog_dis/100;

// cklim start here for all users 
              $show_head = 0;
              $user_count = 0;

              foreach ( $user_object as $service_data) {
                ++$user_count;
                echo "<tr>";
                echo "<td>".$user_count."</td>";
                echo "<td>".$service_data->id."</td>";
                echo "<td>".$service_data->name."</td>";
                $total_head = 0;
                $total_head1 = 0;
                $total_sum = 0;
                $total_sum_service = 0;
                $total_sum_product = 0;
                $total_heads = 0;
                $total_customer=0;
                $total_voucher_value=0;


                $sub_inv = InvoiceSub::find_by_invoice_id_date_range_invoice($from_date, $to_date, $service_data->id);
                // echo '<pre>';
                // print_r($sub_inv[0]->invoice_id);
                // die;
                $invoice_id = 0;
                $general_head_count = 0;
                foreach ($sub_inv as $calculatoon_1) {

                  $total_voucher_query=mysqli_query($con,"select * from user_voucher_commission where invoice_id='$calculatoon_1->invoice_id' and user_id='$service_data->id'");
                 
                  while($voucher_fetch=mysqli_fetch_array($total_voucher_query))
                  {
                    $total_voucher_value=$voucher_fetch['voucher_value']+$total_voucher_value;

                    $total_voucher_invoice_id=$voucher_fetch['invoice_id'];
                    $invoice_voucher_get = Invoice::find_by_id($total_voucher_invoice_id);
                    // echo '<pre>';
                    // print_r($invoice_voucher_get->invoice_voucher);
                    // die;
                   
                  }

                  $general_head_count = 0;
                  $sub_data = InvoiceSub::find_all_invoice_id($calculatoon_1->invoice_id);
                  foreach($sub_data as $data){
                    if($data->ops1_user == $service_data->id || $data->ops2_user == $service_data->id){
                      if($data->sub_total!=0)

                      //  $commission_per=((($data->ops1*100)/$data->sub_total)/100);
                      if (($data->ops1>0 &&  $data->ops2==0) )  {
                        $commission_per=1;
                      }else if ($data->ops1>0 && $data->ops2>0) {
                        $commission_per=0.5;
                      }
                      // echo $commission_per."  ".$data->invoice_id."  ".$data->ops1_user ." ".$data->category."<br>";

                    }

                  }

                  $total_heads = $total_heads + $general_head_count;
                  // echo $general_head_count."<br/>";
                }


                // echo "<br/>head count: ".$total_heads;
                $ser_started = 0;
                $started = 0;

                foreach ($cat_object as $cat_data) {
                  $sub_invoice_obj = InvoiceSub::find_by_invoice_id_date_range_cat1($from_date, $to_date, $service_data->id, $cat_data->id);

                  $sum1 = 0;
                  $sum2 = 0;
                  $sum3 = 0;

                  $head1 = 0;
                  $head2 = 0;
                  $head3 = 0;

                  $commission_per=0;
                  $commission_per1=0;
                  $commission_per2=0;

                  $head_count=0;
                  $head_count1=0;
                  $head_count2=0;

                  $general_head_count = 1;
                  foreach ($sub_invoice_obj as $calculatoon_1) {
                    if($calculatoon_1->ops2 > 0){
                      $general_head_count = 0.5;
                    }
                  }


                  foreach ($sub_invoice_obj as $calculatoon) {
                    // echo '<pre>';
                    // print_r($calculatoon);
                    // die;
                    if($calculatoon->item_type == 2){
                     
                      $service_boolean=true;
                      if($calculatoon->ops1_user == $service_data->id){
                        $sum1 = $sum1 + $calculatoon->ops1;

                        $head1 = $general_head_count;

                        // $commission_per=((($calculatoon->ops1*100)/$calculatoon->sub_total)/100);
                        if (($calculatoon->ops1>0 &&  $calculatoon->ops2==0) )  {
                          $commission_per=1;
                        }else if ($calculatoon->ops1>0 && $calculatoon->ops2>0) {
                          $commission_per=0.5;
                        }
                        $q1="SELECT MAX(ops1) FROM `invoice_sub` WHERE item_type=2 AND invoice_id=$calculatoon->invoice_id AND (`ops1_user`='$service_data->id')";

                        $retv=mysqli_query($con,$q1);
                        $res11=mysqli_fetch_array($retv);
                        $big1=$res11[0];

                        $q2="SELECT MAX(ops2) FROM `invoice_sub` WHERE item_type=2 AND invoice_id=$calculatoon->invoice_id AND (`ops2_user`='$service_data->id')";

                        $retv2=mysqli_query($con,$q2);
                        $res12=mysqli_fetch_array($retv2);
                        $big2=$res12[0];
                        $max=$big1;
                        if($max<$big2)
                        $max=$big2;
                        if($calculatoon->ops1>=$max)
                        {
                          $head_count=$head_count+$commission_per;
                        }

                      }
                      if($calculatoon->ops2_user == $service_data->id){
                        $sum1 = $sum1 + $calculatoon->ops2;
                        // HEAD COUNT ALGORTHM
                        // $head1 = $head1 + 0.5;
                        $head1 = $general_head_count;
                        //$commission_per=((($calculatoon->ops2*100)/$calculatoon->sub_total)/100);
                        if (($calculatoon->ops2>0 &&  $calculatoon->ops1==0))  {
                          $commission_per=1;
                        }else if ($calculatoon->ops1>0 && $calculatoon->ops2>0) {
                          $commission_per=0.5;
                        }

                        /*if ($commission_per>0 && $commission_per<1) {
                        $commission_per=0.5;
                      }else if ($commission_per==1) {
                      $commission_per=1;
                    }else
                    {
                    $commission_per=0;
                  }
                  */
                  $q1="SELECT MAX(ops1) FROM `invoice_sub` WHERE item_type=2 AND invoice_id=$calculatoon->invoice_id AND (`ops1_user`='$service_data->id')";

                  $retv=mysqli_query($con,$q1);
                  $res11=mysqli_fetch_array($retv);
                  $big1=$res11[0];

                  $q2="SELECT MAX(ops2) FROM `invoice_sub` WHERE item_type=2 AND invoice_id=$calculatoon->invoice_id AND (`ops2_user`='$service_data->id')";

                  $retv2=mysqli_query($con,$q2);
                  $res12=mysqli_fetch_array($retv2);
                  $big2=$res12[0];
                  $max=$big1;
                  if($max<$big2)
                  $max=$big2;
                  if($calculatoon->ops2>=$max)
                  {
                    $head_count=$head_count+$commission_per;
                  }


                  //echo $commission_per.",".$calculatoon->ops2."</br>";
                }

              }else if($calculatoon->item_type == 3){
                if($calculatoon->ops1_user == $service_data->id){
                  $sum2 = $sum2 + $calculatoon->ops1;
                  // if($calculatoon->ops2 == 1){
                  //   $head2 = $head2 + 1;
                  // }else{
                  //   $head2 = $head2 + 0.5;
                  // }
                  $head2 = $general_head_count;
                  // $commission_per1=((($calculatoon->ops1*100)/$calculatoon->sub_total)/100);
                  if (($calculatoon->ops1>0 &&  $calculatoon->ops2==0) )  {
                    $commission_per1=1;
                  }else if ($calculatoon->ops1>0 && $calculatoon->ops2>0) {
                    $commission_per1=0.5;
                  }
                  /*if ($commission_per1>0 && $commission_per1<1) {
                  $commission_per1=0.5;
                }else if ($commission_per1==1) {
                $commission_per1=1;
              }else
              {
              $commission_per1=0;
            }*/

            $q22="SELECT * FROM `invoice_sub` WHERE item_type=2  AND invoice_id=$calculatoon->invoice_id AND (`ops1_user`='$service_data->id' or `ops2_user`='$service_data->id')";

            $retv22=mysqli_query($con,$q22);
            if(mysqli_num_rows($retv22)<=0)
            {


              $q1="SELECT MAX(ops1) FROM `invoice_sub` WHERE item_type=3 AND invoice_id=$calculatoon->invoice_id AND (`ops1_user`='$service_data->id')";

              $retv=mysqli_query($con,$q1);
              $res11=mysqli_fetch_array($retv);
              $big1=$res11[0];

              $q2="SELECT MAX(ops2) FROM `invoice_sub` WHERE item_type=3 AND invoice_id=$calculatoon->invoice_id AND (`ops2_user`='$service_data->id')";

              $retv2=mysqli_query($con,$q2);
              $res12=mysqli_fetch_array($retv2);
              $big2=$res12[0];
              $max=$big1;
              if($max<$big2)
              $max=$big2;
              if($calculatoon->ops1>=$max)
              {
                $head_count1=$head_count1+$commission_per1;
              }
            }

          }
          if($calculatoon->ops2_user == $service_data->id){
            $sum2 = $sum2 + $calculatoon->ops2;
            // $head2 = $head2 + 0.5;
            $head2 = $general_head_count;
            // $commission_per1=((($calculatoon->ops2*100)/$calculatoon->sub_total)/100);

            if ( ($calculatoon->ops2>0 &&  $calculatoon->ops1==0))  {
              $commission_per1=1;
            }else if ($calculatoon->ops1>0 && $calculatoon->ops2>0) {
              $commission_per1=0.5;
            }
            /*if ($commission_per1>0 && $commission_per1<1) {
            $commission_per1=0.5;
          }else if ($commission_per1==1) {
          $commission_per1=1;
        }else
        {
        $commission_per1=0;
      }*/

      $q22="SELECT * FROM `invoice_sub` WHERE item_type=2  AND invoice_id=$calculatoon->invoice_id AND (`ops1_user`='$service_data->id' or `ops2_user`='$service_data->id')";

      $retv22=mysqli_query($con,$q22);
      if(mysqli_num_rows($retv22)<=0)
      {
        $q1="SELECT MAX(ops1) FROM `invoice_sub` WHERE item_type=3 AND invoice_id=$calculatoon->invoice_id AND (`ops1_user`='$service_data->id')";

        $retv=mysqli_query($con,$q1);
        $res11=mysqli_fetch_array($retv);
        $big1=$res11[0];

        $q2="SELECT MAX(ops2) FROM `invoice_sub` WHERE item_type=3 AND invoice_id=$calculatoon->invoice_id AND (`ops2_user`='$service_data->id')";

        $retv2=mysqli_query($con,$q2);
        $res12=mysqli_fetch_array($retv2);
        $big2=$res12[0];
        $max=$big1;
        if($max<$big2)
        $max=$big2;
        if($calculatoon->ops2>=$max)
        {
          $head_count1=$head_count1+$commission_per1;
        }
      }
    }

  }else if($calculatoon->item_type == 4){
    if($calculatoon->ops1_user == $service_data->id){
      $sum3 = $sum3 + $calculatoon->ops1;
      // if($calculatoon->ops2 == 1){
      //   $head3 = $head3 + 1;
      // }else{
      //   $head3 = $head3 + 0.5;
      // }
      $head3 = $general_head_count;
      //  $commission_per2=((($calculatoon->ops1*100)/$calculatoon->sub_total)/100);
      if (($calculatoon->ops1>0 &&  $calculatoon->ops2==0) )  {
        $commission_per2=1;
      }else if ($calculatoon->ops1>0 && $calculatoon->ops2>0) {
        $commission_per2=0.5;
      }

      /*if ($commission_per2>0 && $commission_per2<1) {
      $commission_per2=0.5;
    }else if ($commission_per2==1) {
    $commission_per2=1;
  }else
  {
  $commission_per2=0;
}*/

$q22="SELECT * FROM `invoice_sub` WHERE (item_type=2 or item_type=3 or item_type=1) AND invoice_id=$calculatoon->invoice_id AND (`ops1_user`='$service_data->id' or `ops2_user`='$service_data->id')";

$retv22=mysqli_query($con,$q22);
if(mysqli_num_rows($retv22)<=0)
{
  $q1="SELECT MAX(ops1) FROM `invoice_sub` WHERE item_type=4 AND invoice_id=$calculatoon->invoice_id AND (`ops1_user`='$service_data->id')";

  $retv=mysqli_query($con,$q1);
  $res11=mysqli_fetch_array($retv);
  $big1=$res11[0];

  $q2="SELECT MAX(ops2) FROM `invoice_sub` WHERE item_type=4 AND invoice_id=$calculatoon->invoice_id AND (`ops2_user`='$service_data->id')";

  $retv2=mysqli_query($con,$q2);
  $res12=mysqli_fetch_array($retv2);
  $big2=$res12[0];
  $max=$big1;
  if($max<$big2)
  $max=$big2;
  if($calculatoon->ops1>=$max)
  {
    $head_count2=$head_count2+$commission_per2;
  }
}
}
if($calculatoon->ops2_user == $service_data->id){
  $sum3 = $sum3 + $calculatoon->ops2;
  // $head3 = $head3 + 0.5;
  $head3 = $general_head_count;
  // $commission_per2=((($calculatoon->ops2*100)/$calculatoon->sub_total)/100);
  if ( ($calculatoon->ops2>0 &&  $calculatoon->ops1==0))  {
    $commission_per2=1;
  }else if ($calculatoon->ops1>0 && $calculatoon->ops2>0) {
    $commission_per2=0.5;
  }
  /*if ($commission_per2>0 && $commission_per2<1) {
  $commission_per2=0.5;
}else if ($commission_per2==1) {
$commission_per2=1;
}else
{
$commission_per2=0;
}*/
$q22="SELECT * FROM `invoice_sub` WHERE (item_type=2 or item_type=3 or item_type=1) AND invoice_id=$calculatoon->invoice_id AND (`ops1_user`='$service_data->id' or `ops2_user`='$service_data->id')";

$retv22=mysqli_query($con,$q22);
if(mysqli_num_rows($retv22)<=0)
{
  $q1="SELECT MAX(ops1) FROM `invoice_sub` WHERE item_type=4 AND invoice_id=$calculatoon->invoice_id AND (`ops1_user`='$service_data->id')";

  $retv=mysqli_query($con,$q1);
  $res11=mysqli_fetch_array($retv);
  $big1=$res11[0];

  $q2="SELECT MAX(ops2) FROM `invoice_sub` WHERE item_type=4 AND invoice_id=$calculatoon->invoice_id AND (`ops2_user`='$service_data->id')";

  $retv2=mysqli_query($con,$q2);
  $res12=mysqli_fetch_array($retv2);
  $big2=$res12[0];
  $max=$big1;
  if($max<$big2)
  $max=$big2;
  if($calculatoon->ops2>=$max)
  {
    $head_count2=$head_count2+$commission_per2;
  }
}
}

}

}

if($sum1 == 0){
  $sum1 = NULL;
}
if($sum2 == 0){
  $sum2 = NULL;
}
if($sum3 == 0){
  $sum3 = NULL;
}

if($sum1 == 0){
  $head1 = NULL;
}
if($sum2 == 0){
  $head2 = NULL;
}
if($sum3 == 0){
  $head3 = NULL;
}

$div1 = "--";
$div2 = "--";
$div3 = "--";

if($sum1 == 0){
  $div1 = NULL;
}
if($sum2 == 0){
  $div2 = NULL;
}
if($sum3 == 0){
  $div3 = NULL;
}

$th = NULL;
if($sum1 > 0){
  $th = $total_heads;
}




if(count($sub_invoice_obj) > 0){
  if($sum1 == 0){
    echo "<td style='text-align:center;'>".$sum1."</td>";
  }else{

    $q1="SELECT MAX(ops1) FROM `invoice_sub` WHERE item_type=2 AND invoice_id=$calculatoon->invoice_id AND (`ops1_user`='$service_data->id')";

    $retv=mysqli_query($con,$q1);
    $res11=mysqli_fetch_array($retv);
    $big1=$res11[0];

    $q2="SELECT MAX(ops2) FROM `invoice_sub` WHERE item_type=2 AND invoice_id=$calculatoon->invoice_id AND (`ops2_user`='$service_data->id')";

    $retv2=mysqli_query($con,$q2);
    $res12=mysqli_fetch_array($retv2);
    $big2=$res12[0];
    $max=$big1;
    if($max<$big2)
    $max=$big2;




    if($sum1>=$max)
    {
      echo "<td style='text-align:center;'>".$sum1." <br/> -- <br/> ".$head_count."  </td>";
      $total_head1 =   $total_head1 +$head_count;
    }else if($head_count!=NULL or $head_count>0){
      echo "<td style='text-align:center;'>".$sum1." <br/> -- <br/> ".$head_count."  </td>";
      $total_head1 =   $total_head1 +$head_count;
    }
    else{
      echo "<td style='text-align:center;'>".$sum1." <br/> -- <br/> </td>";
      $total_head1 =   $total_head1 +$head_count;
    }
  }

  if($sum2 == 0){
    echo "<td style='text-align:center;'>".$sum2."</td>";
  }else{

    $q22="SELECT * FROM `invoice_sub` WHERE item_type=2  AND invoice_id=$calculatoon->invoice_id AND (`ops1_user`='$service_data->id' or `ops2_user`='$service_data->id')";

    $retv22=mysqli_query($con,$q22);
    if(mysqli_num_rows($retv22)<=0)
    {
      echo "<td style='text-align:center;'>".$sum2." <br/> -- <br/> ".$head_count1 ."</td>";
      $total_head1 =   $total_head1 +$head_count1;
    }else{
      echo "<td style='text-align:center;'>".$sum2." <br/> -- <br/>  </td>";

    }
  }

  if($sum3 == 0){
    echo "<td style='text-align:center;'>".$sum3."</td>";
  }else{
    $q22="SELECT * FROM `invoice_sub` WHERE (item_type=2 or item_type=3 or item_type=1) AND invoice_id=$calculatoon->invoice_id AND (`ops1_user`='$service_data->id' or `ops2_user`='$service_data->id')";

    $retv22=mysqli_query($con,$q22);
    if(mysqli_num_rows($retv22)<=0)
    {
      echo "<td style='text-align:center;'>".$sum3." <br/> -- <br/> ".$head_count2." </td>";
      $total_head1 =   $total_head1 +$head_count2;
    }else{
      echo "<td style='text-align:center;'>".$sum3." <br/> -- <br/>  </td>";
    }
  }

  $started = 1;
  if($sum1 == NULL && $sum2 == NULL && $sum3 == NULL && $ser_started == 0){
    $ser_started = 0;
  }else{
    $ser_started = 1;
  }
  // echo '<pre>';
  // print_r($sum2);
  // die;
  // $total_head = $head1 + $head2 + $head3;
  $total_sum = $total_sum +$sum1 + $sum2 + $sum3;
  // echo '<pre>';
  // print_r($total_sum);
  // die;
}else{
  echo "<td style='text-align:center;'></td>";
  echo "<td style='text-align:center;'></td>";
  echo "<td style='text-align:center;'></td>";
}

}

$total_sum_a = 0;
$total_sum_b = 0;
$total_sum_a = $total_sum;

$pro_started = 0;
foreach ($pro_object as $pro_data) {

  $sub_invoice_obj = InvoiceSub::find_by_invoice_id_date_range_pro($from_date, $to_date, $service_data->id, $pro_data->id);

  $sum1_pro = 0;
  $head1_pro = 0;
  $head_pro_count=0;
  $head_pro_count1=0;
  $comission_pro_per=0;
  $commission_pro_per1=0;
  $commission_pro_per =0;


  $general_head_count = 1;
  foreach ($sub_invoice_obj as $calculatoon_1) {
    if($calculatoon_1->ops2 > 0){
      $general_head_count = 0.5;
    }
  }

  foreach($sub_invoice_obj as $calculatoon){

    if($calculatoon->ops1_user == $service_data->id){
      $sum1_pro = $sum1_pro + $calculatoon->ops1;
     if (($calculatoon->ops1>0) &&  ($calculatoon->ops2==0) )  {
        $commission_pro_per=1;
      }else if (($calculatoon->ops1>0) && ($calculatoon->ops2>0)) {
        $commission_pro_per=0.5;
      } 
     $head_pro_count=$head_pro_count+$commission_pro_per;
      if ( ($calculatoon->ops1>0) &&  ($calculatoon->ops2==0))  {
        $commission_pro_per1=1;
      }else if (($calculatoon->ops1>0) && ($calculatoon->ops2>0)) {
        $commission_pro_per1=0.5;
      } 
      /*if ($commission_per1>0 && $commission_per1<1) {
      $commission_per1=0.5;
    }else if ($commission_per1==1) {
    $commission_per1=1;
  }else
  {
  $commission_per1=0;
}*/
// echo "before type 1 and 2 headcount =";
// echo $commission_pro_per1;
$q1="SELECT * FROM `invoice_sub` WHERE item_type=1 AND item_type=2 AND invoice_id=$calculatoon->invoice_id AND (`ops1_user`='$service_data->id')  ";
$retv22=mysqli_query($con,$q1);
if(mysqli_num_rows($retv22)<=0)
{
  $head_pro_count1=$head_pro_count1+$commission_pro_per1;
  // echo " i am inside here for type 1 and 2";
  // echo  $head_pro_count1;

}
// if($calculatoon->ops2 == 1){
//   $head1_pro = $head1_pro + 1;
// }else{
//   $head1_pro = $head1_pro + 0.5;
// }
$head1_pro = $general_head_count;
}
if($calculatoon->ops2_user == $service_data->id){
 // echo " i am here for type 1 and 2";
  $sum1_pro = $sum1_pro + $calculatoon->ops2;
  // $head1_pro = $head1_pro + 0.5;
  $head1_pro = $general_head_count;
  if (($calculatoon->ops2>0 &&  $calculatoon->ops1==0) )  {
    $commission_pro_per=1;
  }else if ($calculatoon->ops1>0 && $calculatoon->ops2>0) {
    $commission_pro_per=0.5;
  }
  $head_pro_count=$head_pro_count+$commission_pro_per;
  if ( ($calculatoon->ops2>0 &&  $calculatoon->ops1==0))  {
    $commission_pro_per1=1;
  }else if ($calculatoon->ops1>0 && $calculatoon->ops2>0) {
    $commission_pro_per1=0.5;
  }
  /*if ($commission_per1>0 && $commission_per1<1) {
  $commission_per1=0.5;
}else if ($commission_per1==1) {
$commission_per1=1;
}else
{
$commission_per1=0;
}*/
$q1="SELECT * FROM `invoice_sub` WHERE item_type=2 AND invoice_id=$calculatoon->invoice_id AND (`ops2_user`='$service_data->id')  ";
$retv22=mysqli_query($con,$q1);
if(mysqli_num_rows($retv22)<=0)
{
  //echo " i am here for type 2";
  $head_pro_count1=$head_pro_count1+$commission_pro_per1;
}
}

}

if($sum1_pro == 0){
  $sum1_pro = NULL;
}

if($head1_pro == 0){
  $head1_pro = NULL;
}

$div1 = "--";

if($head1_pro == 0){
  $div1 = NULL;
}

// echo $pro_data->commission;

$procom = $pro_data->commission;
// echo $procom."<br/>";
if($procom == NULL){
  $procom = 0;
}
$procom = $procom / 100;


if($sum1_pro > 0){

  if($started = 0 ){
    echo "<td colspan='3' style='text-align:center;'>".$sum1_pro."  <br/> ".$div1." </td>";

  }else{

    $q1="SELECT * FROM `invoice_sub` WHERE  (item_type=2 or item_type=3) AND invoice_id=$calculatoon->invoice_id  ";
    $retv22=mysqli_query($con,$q1);
    if(mysqli_num_rows($retv22)<=0)
    {
      echo "<td colspan='3' style='text-align:center;'>".$sum1_pro." <br/> -- <br/> ". $head_pro_count1." </td>";
      $total_head1 =   $total_head1 +$head_pro_count1;
      //echo " i am here for type 2 and 3";

    }else{
      echo "<td colspan='3' style='text-align:center;'>".$sum1_pro." <br/> -- <br/>  </td>";
    }
  }
  // $total_head = $total_head + $head1_pro;
  $total_sum = $total_sum + $sum1_pro;
  $total_sum_b = $total_sum_b + ($sum1_pro * $procom);

  $pro_started = 1;
}else{
  echo "<td colspan='3' style='text-align:center;'></td>";
}

}

// $service_user = $_POST['service_user'];
// $from_date = $_POST['from_date'];
// $to_date = $_POST['to_date'];

// echo $service_data->id.'<br/>';

$ops1_commision_a = 0;
$ops1_commision_b = 0;
$ops2_commision_a = 0;
$ops2_commision_b = 0;

$ops1_user = 0;
$ops2_user = 0;

$commision = InvoiceSub::find_by_invoice_id_date_range_last_2($service_data->id, $from_date, $to_date);
foreach($commision as $commision_data){

  $ops1_user = $commision_data->ops1_user;
  $ops2_user = $commision_data->ops2_user;

  if($commision_data->ops1_commision_a > 0){
    $ops1_commision_a = $commision_data->ops1_commision_a;
  }

  if($commision_data->ops1_commision_b > 0){
    $ops1_commision_b = $commision_data->ops1_commision_b;
  }

  if($commision_data->ops2_commision_a > 0){
    $ops2_commision_a = $commision_data->ops2_commision_a;
  }

  if($commision_data->ops2_commision_b > 0){
    $ops2_commision_b = $commision_data->ops2_commision_b;
  }

}

$commision_data_a = 0;
$commision_data_b = 0;
$test = "NULL";
if(!empty($commision)){

  // if($commision->ops1_user == $service_data->id && $commision->ops2 != $service_data->id){
  //   $test = "one";
  //   $commision_data_a = $commision_data_a + $commision->ops1_commision_a;
  //   $commision_data_b = $commision_data_b + $commision->ops1_commision_b;
  // }else if($commision->ops2_user == $service_data->id && $commision->ops1_user != $service_data->id){
  //   $test = "two";
  //   $commision_data_a = $commision_data_a + $commision->ops2_commision_a;
  //   $commision_data_b = $commision_data_b + $commision->ops2_commision_b;
  // }else if($commision->ops1_user == $service_data->id && $commision->ops2_user == $service_data->id){
  //   $test = "three";
  //   $commision_data_a = $commision_data_a + $commision->ops1_commision_a + $commision->ops2_commision_a;
  //   $commision_data_b = $commision_data_b + $commision->ops1_commision_b + $commision->ops2_commision_a;
  // }

  if($ops1_user == $service_data->id && $ops2_user != $service_data->id){
    $commision_data_a = $commision_data_a + $ops1_commision_a;
    $commision_data_b = $commision_data_b + $ops1_commision_b;
  }else if($ops2_user == $service_data->id && $ops1_user != $service_data->id){
    $commision_data_a = $commision_data_a + $ops2_commision_a;
    $commision_data_b = $commision_data_b + $ops2_commision_b;
  }else if($ops1_user == $service_data->id && $ops2_user == $service_data->id){
    $commision_data_a = $commision_data_a + $ops1_commision_a + $ops2_commision_a;
    $commision_data_b = $commision_data_b + $ops1_commision_b + $ops2_commision_a;
  }

}
//$total_head = $total_head + $general_head_count;
echo "<td style='text-align:center;'> ".number_format($total_head1,2)." </td>";
echo "<td style='text-align:center;'>".number_format($total_sum,2)."</td>";
if($total_sum > 0){
  //  echo "<td style='text-align:center;'>".$total_heads."</td>";
}else{
  // echo "<td style='text-align:center;'>0</td>";
}
if($total_sum == 0){
  $commision_data_b = 0;
}
// echo $ser_started;
if($ser_started == 0){
  $commision_data_a = 0;
}

if($pro_started == 0){
  $commision_data_b = 0;
}



/*  	 $sub_inv = InvoiceSub::find_by_invoice_id_date_range_invoice($from_date, $to_date, $service_data->id);
$user_id=$service_data->id;
$voucher_val=0;
$vouchernumber=array();
foreach($sub_inv as $data){

$iid=$data->invoice_id()->id;
$q22="SELECT * FROM `invoice_sub` WHERE  invoice_id='$iid' ";
$retv22=mysqli_query($con,$q22);
while($resu=mysqli_fetch_array($retv22))
{
//  print_r($data);

$voucher = Voucher::find_by_voucher_number($data->invoice_id()->invoice_voucher);
$vouchercheck=(in_array($data->invoice_id()->invoice_voucher,$vouchernumber))?1:0;


$user_com_val=($resu['ops1_user']==$user_id)?$resu['ops1']:$resu['ops2'];
if(!empty($voucher) && $user_com_val!=0 && $vouchercheck==0){

$voucher_val=$voucher_val+$voucher->voucher_value;
array_push($vouchernumber,$data->invoice_id()->invoice_voucher);
}
}
}
*/
//echo $total_voucher_value."<br>";
echo "<td style='text-align:center;'> ".number_format($total_voucher_value,2)." </td>";
// calculate commision ops1 calculation
$final_commision_ops1_a= 0;
if($total_sum_a<$total_voucher_value)
{
  $sub_total_a = $total_sum-$total_voucher_value;
}
else
{
  $sub_total_a = $total_sum_a-$total_voucher_value;
}
$sub_total_a = $sub_total_a - (($sub_total_a*$cog)/100);
if($sub_total_a <= 6000){
  $final_commision_ops1_a = $sub_total_a * 0.3;
}else if($sub_total_a <= 12000){
  $final_commision_ops1_a = 1800 + (($sub_total_a - 6001) * 0.33);
}else if($sub_total_a <= 18000){
  $final_commision_ops1_a = 1800 + 1980 + (($sub_total_a - 12001) * 0.36);
}else if($sub_total_a <= 24000){
  $final_commision_ops1_a = 1800 + 1980 + 2160 + (($sub_total_a - 18001) * 0.39);
}else if($sub_total_a <= 30000){
  $final_commision_ops1_a = 1800 + 1980 + 2160 + 2340 + (($sub_total_a - 24001) * 0.42);
}else if($sub_total_a <= 36000){
  $final_commision_ops1_a = 1800 + 1980 + 2160 + 2340 + 2520 + (($sub_total_a - 30001) * 0.45);
}else if($sub_total_a > 36000){
  $final_commision_ops1_a = 1800 + 1980 + 2160 + 2340 + 2520 + 2700 + (($sub_total_a - 36001) * 0.50);
}

$commision_data_a = $final_commision_ops1_a;
// end of calculation commision ops1 calculation

echo "<td style='text-align:center;'> COMMISION A: ".number_format($commision_data_a,2)." <br/> COMMISION B: ".$total_sum_b." </td>";



echo "</tr>";

}
// cklim END OF FOR ALL USERS

}
else
{
  $branch = $_POST['branch'];
  $user_id = $_POST['service_user'];
  $service_data = User::find_by_id($user_id);


  $cog = Branch::find_by_id($branch)->cog;
  $cog_dis = 100 - $cog;
  $cog_dis = $cog_dis/100;

  // FOR ALL USERS
  $show_head = 0;

  ++$user_count;
  echo "<tr>";
  echo "<td>1</td>";
  echo "<td>".$service_data->id."</td>";
  echo "<td>".$service_data->name."</td>";
  $total_head = 0;
  $total_sum = 0;
  $total_heads = 0;
  $total_customer=0;
  $total_head1 = 0;
  $total_voucher_value=0;
  $sub_inv = InvoiceSub::find_by_invoice_id_date_range_invoice($from_date, $to_date, $service_data->id);

  $invoice_id = 0;
  $general_head_count = 0;
  foreach ($sub_inv as $calculatoon_1) {
   $total_voucher_query=mysqli_query($con,"select * from user_voucher_commission where invoice_id='$calculatoon_1->invoice_id' and user_id='$service_data->id'");
    while($voucher_fetch=mysqli_fetch_array($total_voucher_query))
    {
      $total_voucher_value=$voucher_fetch['voucher_value']+$total_voucher_value;
    }
    $general_head_count = 0;
    $sub_data = InvoiceSub::find_all_invoice_id($calculatoon_1->invoice_id);
    foreach($sub_data as $data){
      if($data->ops1_user == $service_data->id || $data->ops2_user == $service_data->id){
        if($data->sub_total!=0)

        //  $commission_per=((($data->ops1*100)/$data->sub_total)/100);
        if (($data->ops1>0 &&  $data->ops2==0) )  {
          $commission_per=1;
        }else if ($data->ops1>0 && $data->ops2>0) {
          $commission_per=0.5;
        }
        // echo $commission_per."  ".$data->invoice_id."  ".$data->ops1_user ." ".$data->category."<br>";

      }

    }

    $total_heads = $total_heads + $general_head_count;
    // echo $general_head_count."<br/>";
  }

  // echo "<br/>head count: ".$total_heads;
  $ser_started = 0;
  $started = 0;
  foreach ($cat_object as $cat_data) {
    $sub_invoice_obj = InvoiceSub::find_by_invoice_id_date_range_cat1($from_date, $to_date, $service_data->id, $cat_data->id);

    $sum1 = 0;
    $sum2 = 0;
    $sum3 = 0;

    $head1 = 0;
    $head2 = 0;
    $head3 = 0;

    $commission_per=0;
    $commission_per1=0;
    $commission_per2=0;

    $head_count=0;
    $head_count1=0;
    $head_count2=0;

    $general_head_count = 1;
    foreach ($sub_invoice_obj as $calculatoon_1) {



      if($calculatoon_1->ops2 > 0){
        $general_head_count = 0.5;
      }
    }


    foreach ($sub_invoice_obj as $calculatoon) {



      if($calculatoon->item_type == 2){
        $service_boolean=true;
        if($calculatoon->ops1_user == $service_data->id){
          $sum1 = $sum1 + $calculatoon->ops1;

          $head1 = $general_head_count;

          // $commission_per=((($calculatoon->ops1*100)/$calculatoon->sub_total)/100);
          if (($calculatoon->ops1>0 &&  $calculatoon->ops2==0) )  {
            $commission_per=1;
          }else if ($calculatoon->ops1>0 && $calculatoon->ops2>0) {
            $commission_per=0.5;
          }
          $q1="SELECT MAX(ops1) FROM `invoice_sub` WHERE item_type=2 AND invoice_id=$calculatoon->invoice_id AND (`ops1_user`='$service_data->id')";

          $retv=mysqli_query($con,$q1);
          $res11=mysqli_fetch_array($retv);
          $big1=$res11[0];

          $q2="SELECT MAX(ops2) FROM `invoice_sub` WHERE item_type=2 AND invoice_id=$calculatoon->invoice_id AND (`ops2_user`='$service_data->id')";

          $retv2=mysqli_query($con,$q2);
          $res12=mysqli_fetch_array($retv2);
          $big2=$res12[0];
          $max=$big1;
          if($max<$big2)
          $max=$big2;
          if($calculatoon->ops1>=$max)
          {
            $head_count=$head_count+$commission_per;
          }

        }
        if($calculatoon->ops2_user == $service_data->id){
          $sum1 = $sum1 + $calculatoon->ops2;
          // HEAD COUNT ALGORTHM
          // $head1 = $head1 + 0.5;
          $head1 = $general_head_count;
          //$commission_per=((($calculatoon->ops2*100)/$calculatoon->sub_total)/100);
          if (($calculatoon->ops2>0 &&  $calculatoon->ops1==0))  {
            $commission_per=1;
          }else if ($calculatoon->ops1>0 && $calculatoon->ops2>0) {
            $commission_per=0.5;
          }

          /*if ($commission_per>0 && $commission_per<1) {
          $commission_per=0.5;
        }else if ($commission_per==1) {
        $commission_per=1;
      }else
      {
      $commission_per=0;
    }
    */
    $q1="SELECT MAX(ops1) FROM `invoice_sub` WHERE item_type=2 AND invoice_id=$calculatoon->invoice_id AND (`ops1_user`='$service_data->id')";

    $retv=mysqli_query($con,$q1);
    $res11=mysqli_fetch_array($retv);
    $big1=$res11[0];

    $q2="SELECT MAX(ops2) FROM `invoice_sub` WHERE item_type=2 AND invoice_id=$calculatoon->invoice_id AND (`ops2_user`='$service_data->id')";

    $retv2=mysqli_query($con,$q2);
    $res12=mysqli_fetch_array($retv2);
    $big2=$res12[0];
    $max=$big1;
    if($max<$big2)
    $max=$big2;
    if($calculatoon->ops2>=$max)
    {
      $head_count=$head_count+$commission_per;
    }


    //echo $commission_per.",".$calculatoon->ops2."</br>";
  }

}else if($calculatoon->item_type == 3){
  if($calculatoon->ops1_user == $service_data->id){
    $sum2 = $sum2 + $calculatoon->ops1;
    // if($calculatoon->ops2 == 1){
    //   $head2 = $head2 + 1;
    // }else{
    //   $head2 = $head2 + 0.5;
    // }
    $head2 = $general_head_count;
    // $commission_per1=((($calculatoon->ops1*100)/$calculatoon->sub_total)/100);
    if (($calculatoon->ops1>0 &&  $calculatoon->ops2==0) )  {
      $commission_per1=1;
    }else if ($calculatoon->ops1>0 && $calculatoon->ops2>0) {
      $commission_per1=0.5;
    }
    /*if ($commission_per1>0 && $commission_per1<1) {
    $commission_per1=0.5;
  }else if ($commission_per1==1) {
  $commission_per1=1;
}else
{
$commission_per1=0;
}*/

$q22="SELECT * FROM `invoice_sub` WHERE item_type=2  AND invoice_id=$calculatoon->invoice_id AND (`ops1_user`='$service_data->id' or `ops2_user`='$service_data->id')";

$retv22=mysqli_query($con,$q22);
if(mysqli_num_rows($retv22)<=0)
{


  $q1="SELECT MAX(ops1) FROM `invoice_sub` WHERE item_type=3 AND invoice_id=$calculatoon->invoice_id AND (`ops1_user`='$service_data->id')";

  $retv=mysqli_query($con,$q1);
  $res11=mysqli_fetch_array($retv);
  $big1=$res11[0];

  $q2="SELECT MAX(ops2) FROM `invoice_sub` WHERE item_type=3 AND invoice_id=$calculatoon->invoice_id AND (`ops2_user`='$service_data->id')";

  $retv2=mysqli_query($con,$q2);
  $res12=mysqli_fetch_array($retv2);
  $big2=$res12[0];
  $max=$big1;
  if($max<$big2)
  $max=$big2;
  if($calculatoon->ops1>=$max)
  {
    $head_count1=$head_count1+$commission_per1;
  }
}

}
if($calculatoon->ops2_user == $service_data->id){
  $sum2 = $sum2 + $calculatoon->ops2;
  // $head2 = $head2 + 0.5;
  $head2 = $general_head_count;
  // $commission_per1=((($calculatoon->ops2*100)/$calculatoon->sub_total)/100);

  if ( ($calculatoon->ops2>0 &&  $calculatoon->ops1==0))  {
    $commission_per1=1;
  }else if ($calculatoon->ops1>0 && $calculatoon->ops2>0) {
    $commission_per1=0.5;
  }
  /*if ($commission_per1>0 && $commission_per1<1) {
  $commission_per1=0.5;
}else if ($commission_per1==1) {
$commission_per1=1;
}else
{
$commission_per1=0;
}*/

$q22="SELECT * FROM `invoice_sub` WHERE item_type=2  AND invoice_id=$calculatoon->invoice_id AND (`ops1_user`='$service_data->id' or `ops2_user`='$service_data->id')";

$retv22=mysqli_query($con,$q22);
if(mysqli_num_rows($retv22)<=0)
{
  $q1="SELECT MAX(ops1) FROM `invoice_sub` WHERE item_type=3 AND invoice_id=$calculatoon->invoice_id AND (`ops1_user`='$service_data->id')";

  $retv=mysqli_query($con,$q1);
  $res11=mysqli_fetch_array($retv);
  $big1=$res11[0];

  $q2="SELECT MAX(ops2) FROM `invoice_sub` WHERE item_type=3 AND invoice_id=$calculatoon->invoice_id AND (`ops2_user`='$service_data->id')";

  $retv2=mysqli_query($con,$q2);
  $res12=mysqli_fetch_array($retv2);
  $big2=$res12[0];
  $max=$big1;
  if($max<$big2)
  $max=$big2;
  if($calculatoon->ops2>=$max)
  {
    $head_count1=$head_count1+$commission_per1;
  }
}

}

}else if($calculatoon->item_type == 4){
  if($calculatoon->ops1_user == $service_data->id){
    $sum3 = $sum3 + $calculatoon->ops1;
    // if($calculatoon->ops2 == 1){
    //   $head3 = $head3 + 1;
    // }else{
    //   $head3 = $head3 + 0.5;
    // }
    $head3 = $general_head_count;
    //  $commission_per2=((($calculatoon->ops1*100)/$calculatoon->sub_total)/100);
    if (($calculatoon->ops1>0 &&  $calculatoon->ops2==0) )  {
      $commission_per2=1;
    }else if ($calculatoon->ops1>0 && $calculatoon->ops2>0) {
      $commission_per2=0.5;
    }

    /*if ($commission_per2>0 && $commission_per2<1) {
    $commission_per2=0.5;
  }else if ($commission_per2==1) {
  $commission_per2=1;
}else
{
$commission_per2=0;
}*/

$q22="SELECT * FROM `invoice_sub` WHERE (item_type=2 or item_type=3 or item_type=1) AND invoice_id=$calculatoon->invoice_id AND (`ops1_user`='$service_data->id' or `ops2_user`='$service_data->id')";

$retv22=mysqli_query($con,$q22);
if(mysqli_num_rows($retv22)<=0)
{
  $q1="SELECT MAX(ops1) FROM `invoice_sub` WHERE item_type=4 AND invoice_id=$calculatoon->invoice_id AND (`ops1_user`='$service_data->id')";

  $retv=mysqli_query($con,$q1);
  $res11=mysqli_fetch_array($retv);
  $big1=$res11[0];

  $q2="SELECT MAX(ops2) FROM `invoice_sub` WHERE item_type=4 AND invoice_id=$calculatoon->invoice_id AND (`ops2_user`='$service_data->id')";

  $retv2=mysqli_query($con,$q2);
  $res12=mysqli_fetch_array($retv2);
  $big2=$res12[0];
  $max=$big1;
  if($max<$big2)
  $max=$big2;
  if($calculatoon->ops1>=$max)
  {
    $head_count2=$head_count2+$commission_per2;
  }
}
}
if($calculatoon->ops2_user == $service_data->id){
  $sum3 = $sum3 + $calculatoon->ops2;
  // $head3 = $head3 + 0.5;
  $head3 = $general_head_count;
  // $commission_per2=((($calculatoon->ops2*100)/$calculatoon->sub_total)/100);
  if ( ($calculatoon->ops2>0 &&  $calculatoon->ops1==0))  {
    $commission_per2=1;
  }else if ($calculatoon->ops1>0 && $calculatoon->ops2>0) {
    $commission_per2=0.5;
  }
  /*if ($commission_per2>0 && $commission_per2<1) {
  $commission_per2=0.5;
}else if ($commission_per2==1) {
$commission_per2=1;
}else
{
$commission_per2=0;
}*/
$q22="SELECT * FROM `invoice_sub` WHERE (item_type=2 or item_type=3 or item_type=1) AND invoice_id=$calculatoon->invoice_id AND (`ops1_user`='$service_data->id' or `ops2_user`='$service_data->id')";

$retv22=mysqli_query($con,$q22);
if(mysqli_num_rows($retv22)<=0)
{
  $q1="SELECT MAX(ops1) FROM `invoice_sub` WHERE item_type=4 AND invoice_id=$calculatoon->invoice_id AND (`ops1_user`='$service_data->id')";

  $retv=mysqli_query($con,$q1);
  $res11=mysqli_fetch_array($retv);
  $big1=$res11[0];

  $q2="SELECT MAX(ops2) FROM `invoice_sub` WHERE item_type=4 AND invoice_id=$calculatoon->invoice_id AND (`ops2_user`='$service_data->id')";

  $retv2=mysqli_query($con,$q2);
  $res12=mysqli_fetch_array($retv2);
  $big2=$res12[0];
  $max=$big1;
  if($max<$big2)
  $max=$big2;
  if($calculatoon->ops2>=$max)
  {
    $head_count2=$head_count2+$commission_per2;
  }
}
}

}

}

if($sum1 == 0){
  $sum1 = NULL;
}
if($sum2 == 0){
  $sum2 = NULL;
}
if($sum3 == 0){
  $sum3 = NULL;
}

if($sum1 == 0){
  $head1 = NULL;
}
if($sum2 == 0){
  $head2 = NULL;
}
if($sum3 == 0){
  $head3 = NULL;
}

$div1 = "--";
$div2 = "--";
$div3 = "--";

if($sum1 == 0){
  $div1 = NULL;
}
if($sum2 == 0){
  $div2 = NULL;
}
if($sum3 == 0){
  $div3 = NULL;
}

$th = NULL;
if($sum1 > 0){
  $th = $total_heads;
}




if(count($sub_invoice_obj) > 0){
  if($sum1 == 0){
    echo "<td style='text-align:center;'>".$sum1."</td>";
  }else{

    $q1="SELECT MAX(ops1) FROM `invoice_sub` WHERE item_type=2 AND invoice_id=$calculatoon->invoice_id AND (`ops1_user`='$service_data->id')";

    $retv=mysqli_query($con,$q1);
    $res11=mysqli_fetch_array($retv);
    $big1=$res11[0];

    $q2="SELECT MAX(ops2) FROM `invoice_sub` WHERE item_type=2 AND invoice_id=$calculatoon->invoice_id AND (`ops2_user`='$service_data->id')";

    $retv2=mysqli_query($con,$q2);
    $res12=mysqli_fetch_array($retv2);
    $big2=$res12[0];
    $max=$big1;
    if($max<$big2)
    $max=$big2;




    if($sum1>=$max)
    {
      echo "<td style='text-align:center;'>".$sum1." <br/> -- <br/> ".$head_count."  </td>";
      $total_head1 =   $total_head1 +$head_count;
    }else if($head_count!=NULL or $head_count>0){
      echo "<td style='text-align:center;'>".$sum1." <br/> -- <br/> ".$head_count."  </td>";
      $total_head1 =   $total_head1 +$head_count;
    }
    else{
      echo "<td style='text-align:center;'>".$sum1." <br/> -- <br/> </td>";
    }
  }

  if($sum2 == 0){
    echo "<td style='text-align:center;'>".$sum2."</td>";
  }else{

    $q22="SELECT * FROM `invoice_sub` WHERE item_type=2  AND invoice_id=$calculatoon->invoice_id AND (`ops1_user`='$service_data->id' or `ops2_user`='$service_data->id')";

    $retv22=mysqli_query($con,$q22);
    if(mysqli_num_rows($retv22)<=0)
    {
      echo "<td style='text-align:center;'>".$sum2." <br/> -- <br/> ".$head_count1 ."</td>";
      $total_head1 =   $total_head1 +$head_count1;
    }else{
      echo "<td style='text-align:center;'>".$sum2." <br/> -- <br/>  </td>";
    }
  }

  if($sum3 == 0){
    echo "<td style='text-align:center;'>".$sum3."</td>";
  }else{
    $q22="SELECT * FROM `invoice_sub` WHERE (item_type=2 or item_type=3 or item_type=1) AND invoice_id=$calculatoon->invoice_id AND (`ops1_user`='$service_data->id' or `ops2_user`='$service_data->id')";

    $retv22=mysqli_query($con,$q22);
    if(mysqli_num_rows($retv22)<=0)
    {
      echo "<td style='text-align:center;'>".$sum3." <br/> -- <br/> ".$head_count2." </td>";
      $total_head1 =   $total_head1 +$head_count2;
    }else{
      echo "<td style='text-align:center;'>".$sum3." <br/> -- <br/>  </td>";
    }
  }

  $started = 1;
  if($sum1 == NULL && $sum2 == NULL && $sum3 == NULL && $ser_started == 0){
    $ser_started = 0;
  }else{
    $ser_started = 1;
  }

  // $total_head = $head1 + $head2 + $head3;
  $total_sum = $total_sum +$sum1 + $sum2 + $sum3;
}else{
  echo "<td style='text-align:center;'></td>";
  echo "<td style='text-align:center;'></td>";
  echo "<td style='text-align:center;'></td>";
}

}

$total_sum_a = 0;
$total_sum_b = 0;
$total_sum_a = $total_sum;

$pro_started = 0;
foreach ($pro_object as $pro_data) {

  $sub_invoice_obj = InvoiceSub::find_by_invoice_id_date_range_pro($from_date, $to_date, $service_data->id, $pro_data->id);

  $sum1_pro = 0;
  $head1_pro = 0;
  $head_pro_count=0;
  $head_pro_count1=0;
  $comission_pro_per=0;
  $commission_pro_per=0;
  $commission_pro_per1=0;


  $general_head_count = 1;
  foreach ($sub_invoice_obj as $calculatoon_1) {
    if($calculatoon_1->ops2 > 0){
      $general_head_count = 0.5;
    }
  }

  foreach($sub_invoice_obj as $calculatoon){

    if($calculatoon->ops1_user == $service_data->id){
      $sum1_pro = $sum1_pro + $calculatoon->ops1;
      if (($calculatoon->ops1>0 &&  $calculatoon->ops2==0) )  {
        $commission_pro_per=1;
      }else if ($calculatoon->ops1>0 && $calculatoon->ops2>0) {
        $commission_pro_per=0.5;
      }
      $head_pro_count=$head_pro_count+$commission_pro_per;
      if ( ($calculatoon->ops1>0 &&  $calculatoon->ops2==0))  {
        $commission_pro_per1=1;
      }else if ($calculatoon->ops1>0 && $calculatoon->ops2>0) {
        $commission_pro_per1=0.5;
      }
      /*if ($commission_per1>0 && $commission_per1<1) {
      $commission_per1=0.5;
    }else if ($commission_per1==1) {
    $commission_per1=1;
  }else
  {
  $commission_per1=0;
}*/
$q1="SELECT * FROM `invoice_sub` WHERE item_type=1 AND item_type=2 AND invoice_id=$calculatoon->invoice_id AND (`ops1_user`='$service_data->id')  ";
$retv22=mysqli_query($con,$q1);
if(mysqli_num_rows($retv22)<=0)
{
  $head_pro_count1=$head_pro_count1+$commission_pro_per1;
}
// if($calculatoon->ops2 == 1){
//   $head1_pro = $head1_pro + 1;
// }else{
//   $head1_pro = $head1_pro + 0.5;
// }
$head1_pro = $general_head_count;
}
if($calculatoon->ops2_user == $service_data->id){
  $sum1_pro = $sum1_pro + $calculatoon->ops2;
  // $head1_pro = $head1_pro + 0.5;
  $head1_pro = $general_head_count;
  if (($calculatoon->ops2>0 &&  $calculatoon->ops1==0) )  {
    $commission_pro_per=1;
  }else if ($calculatoon->ops1>0 && $calculatoon->ops2>0) {
    $commission_pro_per=0.5;
  }
  $head_pro_count=$head_pro_count+$commission_pro_per;
  if ( ($calculatoon->ops2>0 &&  $calculatoon->ops1==0))  {
    $commission_pro_per1=1;
  }else if ($calculatoon->ops1>0 && $calculatoon->ops2>0) {
    $commission_pro_per1=0.5;
  }
  /*if ($commission_per1>0 && $commission_per1<1) {
  $commission_per1=0.5;
}else if ($commission_per1==1) {
$commission_per1=1;
}else
{
$commission_per1=0;
}*/
$q1="SELECT * FROM `invoice_sub` WHERE item_type=2 AND invoice_id=$calculatoon->invoice_id AND (`ops2_user`='$service_data->id')  ";
$retv22=mysqli_query($con,$q1);
if(mysqli_num_rows($retv22)<=0)
{
  $head_pro_count1=$head_pro_count1+$commission_pro_per1;
}
}

}

if($sum1_pro == 0){
  $sum1_pro = NULL;
}

if($head1_pro == 0){
  $head1_pro = NULL;
}

$div1 = "--";

if($head1_pro == 0){
  $div1 = NULL;
}

// echo $pro_data->commission;

$procom = $pro_data->commission;
if($procom == NULL){
  $procom = 0;
}
$procom = $procom / 100;
// echo $procom."<br/>";


if($sum1_pro > 0){

  if($started = 0 ){
    echo "<td colspan='3' style='text-align:center;'>".$sum1_pro."  <br/> ".$div1." </td>";
  }else{

    $q1="SELECT * FROM `invoice_sub` WHERE  (item_type=2 or item_type=3) AND invoice_id=$calculatoon->invoice_id  ";
    $retv22=mysqli_query($con,$q1);
    if(mysqli_num_rows($retv22)<=0)
    {
      echo "<td colspan='3' style='text-align:center;'>".$sum1_pro." <br/> -- <br/> ". $head_pro_count1." </td>";
      $total_head1 =   $total_head1 +$head_pro_count1;
    }else{
      echo "<td colspan='3' style='text-align:center;'>".$sum1_pro." <br/> -- <br/>  </td>";
    }
  }
  // $total_head = $total_head + $head1_pro;
  $total_sum = $total_sum + $sum1_pro;
  $total_sum_b = $total_sum_b + ($sum1_pro * $procom);

  $pro_started = 1;
}else{
  echo "<td colspan='3' style='text-align:center;'></td>";
}

}

// $service_user = $_POST['service_user'];
// $from_date = $_POST['from_date'];
// $to_date = $_POST['to_date'];

// echo $service_data->id.'<br/>';

$ops1_commision_a = 0;
$ops1_commision_b = 0;
$ops2_commision_a = 0;
$ops2_commision_b = 0;

$ops1_user = 0;
$ops2_user = 0;

$commision = InvoiceSub::find_by_invoice_id_date_range_last_2($service_data->id, $from_date, $to_date);
foreach($commision as $commision_data){

  $ops1_user = $commision_data->ops1_user;
  $ops2_user = $commision_data->ops2_user;

  if($commision_data->ops1_commision_a > 0){
    $ops1_commision_a = $commision_data->ops1_commision_a;
  }

  if($commision_data->ops1_commision_b > 0){
    $ops1_commision_b = $commision_data->ops1_commision_b;
  }

  if($commision_data->ops2_commision_a > 0){
    $ops2_commision_a = $commision_data->ops2_commision_a;
  }

  if($commision_data->ops2_commision_b > 0){
    $ops2_commision_b = $commision_data->ops2_commision_b;
  }

}

$commision_data_a = 0;
$commision_data_b = 0;
$test = "NULL";
if(!empty($commision)){

  // if($commision->ops1_user == $service_data->id && $commision->ops2 != $service_data->id){
  //   $test = "one";
  //   $commision_data_a = $commision_data_a + $commision->ops1_commision_a;
  //   $commision_data_b = $commision_data_b + $commision->ops1_commision_b;
  // }else if($commision->ops2_user == $service_data->id && $commision->ops1_user != $service_data->id){
  //   $test = "two";
  //   $commision_data_a = $commision_data_a + $commision->ops2_commision_a;
  //   $commision_data_b = $commision_data_b + $commision->ops2_commision_b;
  // }else if($commision->ops1_user == $service_data->id && $commision->ops2_user == $service_data->id){
  //   $test = "three";
  //   $commision_data_a = $commision_data_a + $commision->ops1_commision_a + $commision->ops2_commision_a;
  //   $commision_data_b = $commision_data_b + $commision->ops1_commision_b + $commision->ops2_commision_a;
  // }

  if($ops1_user == $service_data->id && $ops2_user != $service_data->id){
    $commision_data_a = $commision_data_a + $ops1_commision_a;
    $commision_data_b = $commision_data_b + $ops1_commision_b;
  }else if($ops2_user == $service_data->id && $ops1_user != $service_data->id){
    $commision_data_a = $commision_data_a + $ops2_commision_a;
    $commision_data_b = $commision_data_b + $ops2_commision_b;
  }else if($ops1_user == $service_data->id && $ops2_user == $service_data->id){
    $commision_data_a = $commision_data_a + $ops1_commision_a + $ops2_commision_a;
    $commision_data_b = $commision_data_b + $ops1_commision_b + $ops2_commision_a;
  }

}
$total_head = $total_head + $general_head_count;
echo "<td style='text-align:center;'> ".number_format($total_head1,2)." </td>";
echo "<td style='text-align:center;'>".number_format($total_sum,2)."</td>";




if($total_heads == 0){
  $total_heads = 1;
}
$sub_inv = InvoiceSub::find_by_invoice_id_date_range_invoice($from_date, $to_date, $service_data->id);
$user_id=$service_data->id;
$voucher_val=0;
$vouchernumber=array();
foreach($sub_inv as $data){

  $iid=$data->invoice_id()->id;
  $q22="SELECT * FROM `invoice_sub` WHERE  invoice_id='$iid' ";
  $retv22=mysqli_query($con,$q22);
  while($resu=mysqli_fetch_array($retv22))
  {
    //  print_r($data);

    $voucher = Voucher::find_by_voucher_number($data->invoice_id()->invoice_voucher);
    $vouchercheck=(in_array($data->invoice_id()->invoice_voucher,$vouchernumber))?1:0;


    $user_com_val=($resu['ops1_user']==$user_id)?$resu['ops1']:$resu['ops2'];
    if(!empty($voucher) && $user_com_val!=0 && $vouchercheck==0){

      $voucher_val=$voucher_val+$voucher->voucher_value;
      array_push($vouchernumber,$data->invoice_id()->invoice_voucher);
    }
  }
}

echo "<td style='text-align:center;'> ".number_format($total_voucher_value,2)." </td>";

if($total_sum > 0){
  //  echo "<td style='text-align:center;'>".$total_heads."</td>";
}else{
  // echo "<td style='text-align:center;'>0</td>";
}
if($total_sum == 0){
  $commision_data_b = 0;
}
// echo $ser_started;
if($ser_started == 0){
  $commision_data_a = 0;
}

if($pro_started == 0){
  $commision_data_b = 0;
}


// calculate commision ops1 calculation
$final_commision_ops1_a= 0;
if($total_sum_a<$total_voucher_value)
{
  $sub_total_a = $total_sum-$total_voucher_value;
}
else
{
  $sub_total_a = $total_sum_a-$total_voucher_value;
}
// $sub_total_a = $sub_total_a * $cog_dis;
$sub_total_a = $sub_total_a - (($sub_total_a*$cog)/100);
if($sub_total_a <= 6000){
  $final_commision_ops1_a = $sub_total_a * 0.3;
}else if($sub_total_a <= 12000){
  $final_commision_ops1_a = 1800 + (($sub_total_a - 6001) * 0.33);
}else if($sub_total_a <= 18000){
  $final_commision_ops1_a = 1800 + 1980 + (($sub_total_a - 12001) * 0.36);
}else if($sub_total_a <= 24000){
  $final_commision_ops1_a = 1800 + 1980 + 2160 + (($sub_total_a - 18001) * 0.39);
}else if($sub_total_a <= 30000){
  $final_commision_ops1_a = 1800 + 1980 + 2160 + 2340 + (($sub_total_a - 24001) * 0.42);
}else if($sub_total_a <= 36000){
  $final_commision_ops1_a = 1800 + 1980 + 2160 + 2340 + 2520 + (($sub_total_a - 30001) * 0.45);
}else if($sub_total_a > 36000){
  $final_commision_ops1_a = 1800 + 1980 + 2160 + 2340 + 2520 + 2700 + (($sub_total_a - 36001) * 0.50);
}

$commision_data_a = $final_commision_ops1_a;
// end of calculation commision ops1 calculation

echo "<td style='text-align:center;'> COMMISION A: ".number_format($commision_data_a,2)." <br/> COMMISION B: ".$total_sum_b." </td>";
echo "</tr>";

}

?>

</tbody>
</table>

<!-- table ends -->
</div>
<?php } ?>
</div>

</body>
</html>
