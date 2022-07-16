<?php
require_once __DIR__.'/../util/initialize.php';

class BranchWorkingTime extends DatabaseObject{
  protected static $table_name="timeslots";
  protected static $db_fields=array();

  protected static $db_fk=array("branch_id"=>"Branch");

  public function branch_id()
  {
    return parent::get_fk_object("branch_id");
  }

}

?>
