<?php
require_once __DIR__.'/../util/initialize.php';

class User extends DatabaseObject{
  protected static $table_name="users";
  protected static $db_fields=array();
  protected static $db_fk=array("user_status_id"=>"UserStatus","designation_id"=>"Designation","branch_id"=>"Branch");

  //    public $id;
  //    public $designation_id;
  //    public $user_status_id;
  //    public $name;
  //    public $username;
  //    public $password;
  //    public $dob;
  //    public $contact_no;
  //    public $email;
  //    public $nic;
  //    public $address;
  //    public $image;


  public function user_status_id(){
    return parent::get_fk_object("user_status_id");
  }

  public function designation_id(){
    return parent::get_fk_object("designation_id");
  }

  public function branch_id(){
    return parent::get_fk_object("branch_id");
  }

  public static function authenticate($username="",$password=""){
    global $database;
    $username=$database->escape_value(trim($username));
    $password=$database->escape_value(trim($password));
    $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE username='{$username}' AND password='{$password}'");
    return array_shift($object_array);
  }

  //    public static function find_max_id(){
  //        global $database;
  //        $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." ORDER BY id DESC LIMIT 1");
  ////        return !empty($object_array) ? array_shift($object_array) : false;
  //        return array_shift($object_array);
  //    }

  public static function getNextCode() {
    $auto_increment=parent::getAutoIncrement();
    return $auto_increment;
  }

  public static function find_by_username($value){
    global $database;
    $value=$database->escape_value($value);
    $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE username='$value'");
    return array_shift($object_array);
  }

  public static function find_all_by_designation_id($value){
    global $database;
    $value=$database->escape_value($value);
    $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE designation_id='$value'");
    return $object_array;
  }

  public static function find_all_service_branch($value){
    global $database;
    $value=$database->escape_value($value);
    $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE designation_id= 5 AND FIND_IN_SET('$value',branch_id) ");
    return $object_array;
  }

  public static function find_name_by_id($value){
    global $database;
    $value=$database->escape_value($value);
    $object_array=self::find_by_sql("SELECT name FROM ".self::$table_name." WHERE id='$value'");
    return array_shift($object_array);
  }
}

?>
