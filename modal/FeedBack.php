<?php
require_once __DIR__.'/../util/initialize.php';

class FeedBack extends DatabaseObject{
  protected static $table_name="feedback";
  protected static $db_fields=array();
  protected static $db_fk=array("customer_id"=>"Customer");

  public function customer_id(){
    return parent::get_fk_object("customer_id");
  }

}

?>
