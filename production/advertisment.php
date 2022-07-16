<?php
require_once './../util/initialize.php';
include 'common/upper_content.php';

if (!(isset($_POST["id"]) && $role = Advertisment::find_by_id($_POST["id"]))) {
  $role = new Advertisment();
}
?>

<!--page content-->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3 style="font-weight:800;">Advertisment</h3>
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
            <h2 id="title" style="font-weight:700;"><?php echo (empty($role->id)) ? 'Add' : 'Edit'; ?> Advertisment </h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">

            <!-- content start -->
            <ul class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#home">Image Content</a></li>
              <li><a data-toggle="tab" href="#menu2">Video Content</a></li>
            </ul>

            <div class="tab-content">
              <div id="home" class="tab-pane fade in active">

                <hr/>
                <!-- content start -->

                <form id="formRole" action="proccess/advertisment_process.php" method="post" class="form-horizontal form-label-left" enctype="multipart/form-data">
                  <div class="col-md-12 col-sm-12 col-xs-12">


                    <input type="hidden" name="ad_type" value="1" />

                    <div class="form-group">
                      <label>IMAGE</label>
                      <input id="inpFile" type="file" name="files_to_upload" />
                    </div>

                    <div class="modal-footer col-md-12 col-sm-12 col-xs-12">
                      <?php if(Functions::check_privilege_by_module_action("Branch","ins")){ ?>
                        <div class=" col-md-4 col-sm-4 col-xs-12">
                          <!--<button id="btnSave" type="submit" name="save" class="btn btn-block btn-success" onclick="return validateForm()"><i class="fa fa-floppy-o"></i> Save</button>-->
                          <button id="btnSave" type="submit" name="save" class="btn btn-block btn-success"><i class="fa fa-floppy-o"></i> Save</button>
                        </div>
                      <?php } ?>
                      <?php if(Functions::check_privilege_by_module_action("Branch","del")){ ?>
                        <div class=" col-md-4 col-sm-4 col-xs-12" style="display: <?php echo (empty($role->id)) ? 'none' : 'initial'; ?>">
                          <!--<button id="btnDelete" type="submit" name="delete" class="btn btn-block btn-danger" onclick="return confirmDelete(this);"><i class="fa fa-trash"></i> Delete</button>-->
                          <button id="btnDelete" type="button" name="delete" class="btn btn-block btn-danger" ><i class="fa fa-trash"></i> Delete</button>
                        </div>
                      <?php } ?>
                      <div class=" col-md-4 col-sm-4 col-xs-12">
                        <a href="branch.php"><button type="button" name="ad_image" class="btn btn-block btn-primary"><i class="fa fa-history"></i> Reset</button></a>
                      </div>
                    </div>
                  </div>
                </form>

                <!-- content ends -->

              </div>
              <div id="menu2" class="tab-pane fade">

                <hr/>

                <!-- content start -->

                <form id="formRole" action="proccess/advertisment_process.php" method="post" class="form-horizontal form-label-left" enctype="multipart/form-data">
                  <div class="col-md-12 col-sm-12 col-xs-12">

                    <input type="hidden" name="ad_type" value="2" />

                    <div class="form-group">
                      <label>VIDEO</label>
                      <input id="inpFile" type="file" name="files_to_upload" />
                    </div>



                    <div class="modal-footer col-md-12 col-sm-12 col-xs-12">
                      <?php if(Functions::check_privilege_by_module_action("Branch","ins")){ ?>
                        <div class=" col-md-4 col-sm-4 col-xs-12">
                          <!--<button id="btnSave" type="submit" name="save" class="btn btn-block btn-success" onclick="return validateForm()"><i class="fa fa-floppy-o"></i> Save</button>-->
                          <button id="btnSave" type="submit" name="save_video" class="btn btn-block btn-success"><i class="fa fa-floppy-o"></i> Save</button>
                        </div>
                      <?php } ?>
                      <?php if(Functions::check_privilege_by_module_action("Branch","del")){ ?>
                        <div class=" col-md-4 col-sm-4 col-xs-12" style="display: <?php echo (empty($role->id)) ? 'none' : 'initial'; ?>">
                          <!--<button id="btnDelete" type="submit" name="delete" class="btn btn-block btn-danger" onclick="return confirmDelete(this);"><i class="fa fa-trash"></i> Delete</button>-->
                          <button id="btnDelete" type="button" name="delete" class="btn btn-block btn-danger" ><i class="fa fa-trash"></i> Delete</button>
                        </div>
                      <?php } ?>
                      <div class=" col-md-4 col-sm-4 col-xs-12">
                        <a href="branch.php"><button type="button" name="reset" class="btn btn-block btn-primary"><i class="fa fa-history"></i> Reset</button></a>
                      </div>
                    </div>
                  </div>
                </form>

                <!-- content ends -->

              </div>
            </div>
            <!-- content ends -->

          </div>
        </div>
      </div>

      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2 id="title" style="font-weight:700;"> Management</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <table id="" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Content</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

                <?php
                $objects = Advertisment::find_all();
                foreach ($objects as $data) {
                  ?>
                  <tr>
                    <td><?php echo $data->id; ?></td>
                    <?php if( $data->type == 1 ){ ?>
                      <td><img src='uploads/advertisment/<?php echo $data->content; ?>' width="100px"></td>
                    <?php }else if($data->type == 2){
                      ?>
                      <td>
                        <video width="220" height="140" controls>
                          <source src="uploads/advertisment/<?php echo $data->content; ?>">
                              Your browser does not support the video tag.
                            </video>
                          </td>
                          <?php
                        } ?>
                        <td>
                          <form action="proccess/advertisment_process.php" method="post" style="float: left;">
                            <input type="hidden" name="id" value="<?php echo $data->id; ?>"/>
                            <button type="submit" name="delete_ad" class="btn btn-danger btn-xs" >delete</button>
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
            <div class="x_panel">

            </div>
          </div>

        </div>
      </div>
    </div>
    <!--/page content-->
    <?php include 'common/bottom_content.php'; ?> bottom content
    <script>

    window.onload = function () {
      //        $.alert({
      //            type: 'red',
      //            title: 'Welcome!',
      //            content: 'Mahesh!',
      //        });
    };

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
        if (UserPrivileges.checkPrivilege("proccess/privileges_authenticate.php", "Advertisment", "upd")) {
          FormOperations.confirmSave(validateForm(), "#formRole", id, null);
        }
      } else {
        if (UserPrivileges.checkPrivilege("proccess/privileges_authenticate.php", "Advertisment", "ins")) {
          FormOperations.confirmSave(validateForm(), "#formRole", id, null);
        }
      }
    });

    $("#btnDelete").click(function () {

      if (UserPrivileges.checkPrivilege("proccess/privileges_authenticate.php", "Advertisment", "del")) {
        FormOperations.confirmDelete("#formRole");
      }
    });
  </script>
