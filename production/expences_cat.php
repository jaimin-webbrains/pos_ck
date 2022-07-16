<?php
require_once './../util/initialize.php';

//if (!(isset($_POST["id"]) && $category = Category::find_by_id($_POST["id"]))) {
//    $category = new Category();
//}

if (isset($_GET["id"])) {
  $id= Functions::custom_crypt($_GET["id"], 'd');
  if($category = Category::find_by_id($id)){

  }else{
    Session::set_error("Entry not available...");
    $category = new Category();
  }
}else{
  $category = new Category();
}

include 'common/upper_content.php';
?>

<!--page content-->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Category</h3>
      </div>

      <div class="title_right">

      </div>
    </div>

    <div class="clearfix"></div>

    <?php Functions::output_result(); ?>

    <div class="row">
      <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2 id="title">Expences Category</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">

            <form action="proccess/expences_cat_process.php" method="post">

              <div class="form-group">
                <label for="pwd">Expnce Cat Name:</label>
                <input type="text" class="form-control" name="cat_name" selected required>
              </div>

              <button type="submit" name="save" class="btn btn-primary btn-block">SAVE</button>
            </form>

          </div>
        </div>
      </div>

      <div class="col-md-8 col-sm-8 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2 id="title">Expences Category Manegement</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">

            <table id="tblMain" class="table table-striped">
              <thead>
                <tr>
                  <th>Category Name</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach(ExpenceCat::find_all_desc() as $expencecat){
                  echo "<tr>";
                  echo "<td>".$expencecat->cat_name."</td>";
                  echo '<td><a href="proccess/expences_cat_process.php?del='.Functions::custom_crypt($expencecat->id).'" class="btn btn-danger btn-xs" role="button">Delete</a></td>';
                  echo "</tr>";
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

$(function () {
  $("#dtpChequeDate").datepicker({
    changeMonth: true,
    changeYear: true,
    dateFormat: 'yy-mm-dd'
  });
});

$(document).ready(function () {
  $('#tblMain').DataTable({
    "paging": false,
    // "ordering": false,
    "order": [[ 0, 'desc' ]],
    "info": false
  });
});

</script>
